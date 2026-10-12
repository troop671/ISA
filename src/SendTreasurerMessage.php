<?php

declare(strict_types=1);

namespace Troop671\Isa;

use PHPMailer\PHPMailer\Exception as MailerException;
use PHPMailer\PHPMailer\PHPMailer;

final readonly class SendTreasurerMessage
{
  public function __construct(private Environment $environment, private string $logoPath)
  {
  }

  public function __invoke(TreasurerMessage $message, TreasurerRequest $request, array $treasurers): array
  {
    return array_values(array_filter(array_map(
      fn (User $treasurer): ?string => $this->sendTo($treasurer->email, $message, $request),
      $treasurers,
    )));
  }

  private function sendTo(string $recipient, TreasurerMessage $message, TreasurerRequest $request): ?string
  {
    try {
      $mailer = new PHPMailer(true);
      $mailer->isSMTP();
      $mailer->Host = $this->environment->smtpHost;
      $mailer->Port = $this->environment->smtpPort;
      $mailer->SMTPAuth = true;
      $mailer->Username = $this->environment->smtpUser;
      $mailer->Password = $this->environment->smtpPassword;
      $mailer->SMTPSecure = match ($this->environment->smtpEncryption) {
        SmtpEncryption::Smtps => PHPMailer::ENCRYPTION_SMTPS,
        SmtpEncryption::StartTls => PHPMailer::ENCRYPTION_STARTTLS,
        SmtpEncryption::None => '',
      };
      $mailer->SMTPAutoTLS = $this->environment->smtpEncryption !== SmtpEncryption::None;
      $mailer->CharSet = PHPMailer::CHARSET_UTF8;
      $mailer->setFrom($this->environment->mailFromAddress, $this->environment->mailFromName);
      $mailer->addReplyTo($request->replyAddress, $request->user->name());
      $mailer->addAddress($recipient);
      $mailer->Subject = $message->subject;
      $mailer->isHTML();
      $mailer->addEmbeddedImage($this->logoPath, 'bsa-logo', 'BSA_Logo.jpg');
      $mailer->Body = $message->body;
      $mailer->AltBody = trim(html_entity_decode(strip_tags($message->summary), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
      $mailer->send();
      return null;
    } catch (MailerException $exception) {
      ReportFailure::write(['Event' => 'TreasurerMessageFailed', 'Recipient' => $recipient, 'Message' => $exception->getMessage()]);
      return $exception->getMessage();
    }
  }
}
