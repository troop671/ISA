# Troop 671 ISA

Troop 671's Individual Scout Account site. Scouts sign in to see their balance and messages, change their account details, recover a password with their security question, and send the Treasurer a withdrawal request or a comment by e-mail. Treasurers create, edit, lock and delete accounts, update every balance at once, and post a General Message to everyone.

## Run locally

`docker compose --env-file Local.env up --build --wait`, then open `http://localhost:8671/ISA/`. Mail the site sends arrives in Mailpit at `http://localhost:8025/`. If you have not used Docker before, follow [Try it locally, step by step](#try-it-locally-step-by-step).

The stack reproduces the DreamHost host `iad1-shared-e1-33.dreamhost.com`: Ubuntu 24.04, Apache 2.4.58 with `mod_fcgid` 2.3.9, PHP 8.3.30 built with DreamHost's configure options, DreamHost's `php.ini` and `phprc`, the site at `/home/dh_vpjbmy/troop671.com/ISA` running as `dh_vpjbmy`, and MySQL 8.0.41 with the host's SQL mode, character sets and time zone. The containers answer to the host's names, `mysql.troop671.com` and `smtp.dreamhost.com`, and Mailpit takes the place of DreamHost's SMTP on port 465 with TLS and authentication.

The local database starts from the production schema with the made-up users in [Sign-in accounts](#sign-in-accounts), stored as SHA-1 hashes in `Docker/Mysql/3-Seed.sql`.

## Try it locally, step by step

This walk-through takes you from a computer without Docker to signing in as a Treasurer and as a Scout, sending a withdrawal request, and reading the e-mail it produces. Nothing you do here reaches the real site or sends real e-mail.

It was tested on a Mac with Apple silicon. Intel Macs and Windows are supported by Docker but these steps have not been run on them.

### What you need

| Item | Requirement |
|---|---|
| Computer | A Mac running one of the three newest major macOS releases, or a 64-bit Windows 10 (22H2) or Windows 11 (23H2 or later) PC, Pro, Enterprise or Education edition. See Docker's [Mac requirements](https://docs.docker.com/desktop/setup/install/mac-install/#system-requirements) and [Windows requirements](https://docs.docker.com/desktop/setup/install/windows-install/#system-requirements). |
| Memory | 4 GB on a Mac, 8 GB on Windows |
| Free disk space | 3 GB. The images use 2.4 GB once built. |
| Internet | Needed the first time, to download Docker and the build ingredients |
| Time | About 15 minutes. The first build alone took 187 s on a 16-core Mac. |
| The code | A copy of this repository, [troop671/ISA](https://github.com/troop671/ISA) on GitHub. No GitHub account is needed to download it. |

### Step 1: Install Docker Desktop

Docker Desktop runs the site's four parts (web server, database, mail catcher and a one-time database upgrade) in isolated containers on your computer.

| Your computer | Download | Install |
|---|---|---|
| Mac with Apple silicon (M1 or later) | [Docker Desktop for Mac with Apple silicon](https://docs.docker.com/desktop/setup/install/mac-install/) | Open `Docker.dmg` and drag **Docker** into **Applications**. |
| Mac with an Intel chip | [Docker Desktop for Mac with Intel chip](https://docs.docker.com/desktop/setup/install/mac-install/) | Open `Docker.dmg` and drag **Docker** into **Applications**. |
| Windows | [Docker Desktop for Windows - x86_64](https://docs.docker.com/desktop/setup/install/windows-install/) | Run `Docker Desktop Installer.exe`. On the **Configuration** page keep **Use WSL 2 instead of Hyper-V** selected. Select **Close** when it finishes. Restart if Windows asks you to. |

To find out which Mac you have, open the Apple menu and choose **About This Mac**: **Chip** means Apple silicon, **Processor** means Intel.

Then:

1. Open **Docker Desktop** (from **Applications** on a Mac, or the **Start** menu on Windows).
2. Select **Accept** on the Docker Subscription Service Agreement. Docker Desktop does not run until you accept. Signing in to a Docker account is not needed. Docker Desktop is free for small organizations; see [Docker's licence terms](https://docs.docker.com/subscription/desktop-license/).
3. Wait until Docker Desktop reports that the engine is running. Leave it open while you use the site.

### Step 2: Get the code

1. Open [github.com/troop671/ISA](https://github.com/troop671/ISA).
2. Select the green **Code** button, then **Download ZIP**.
3. Unzip it: on a Mac, double-click the ZIP; on Windows, right-click it and choose **Extract All**. You get a folder named `ISA-main` that contains `README.md` and `docker-compose.yaml`.

### Step 3: Open a terminal in that folder

| Your computer | Do this |
|---|---|
| Mac | Open **Terminal** (in **Applications** > **Utilities**). Type `cd` followed by a space, drag the folder from Finder into the Terminal window, and press **Return**. |
| Windows 11 | Open the folder in File Explorer, right-click an empty area, and choose **Open in Terminal**. |
| Windows 10 | Open the folder in File Explorer, click the address bar, type `powershell`, and press **Enter**. |

Check that Docker is reachable by typing this and pressing **Return** or **Enter**:

```
docker compose version
```

It prints a line such as `Docker Compose version v5.5.1`. If it prints an error instead, see [Troubleshooting](#troubleshooting).

### Step 4: Start the site

Type:

```
docker compose --env-file Local.env up --build --wait
```

The first time, Docker downloads its ingredients and builds PHP, which takes several minutes. When it finishes you get your prompt back, and the last lines say `Healthy` for `application`, `mysql` and `smtp`, and `Exited` for `migrate`, the one-time database upgrade. Later starts take seconds.

| Address | What it is |
|---|---|
| [http://localhost:8671/ISA/](http://localhost:8671/ISA/) | The ISA site |
| [http://localhost:8025/](http://localhost:8025/) | Mailpit, which catches every e-mail the site sends |

### Step 5: Sign in as the Treasurer

1. Open [http://localhost:8671/ISA/](http://localhost:8671/ISA/) in your web browser. The **Troop 671 User Login** box appears.
2. Enter **User ID** `treasurer` and **Password** `Treasurer671`, then select **login**.
3. The page says **Welcome back Pat!** and, after 2 seconds, opens the **Treasurer Menu**. It lists every Scout under **USERS** and every Treasurer under **TREASURERS**.
4. Select **LOGOUT** at the top. The login page says **You have been successfully logged out.**

### Step 6: Sign in as a Scout and send a withdrawal request

1. Enter **User ID** `scout` and **Password** `Scout671`, then select **login**.
2. The **Account Menu** opens with **.::Welcome Back Sam!** and an **Account Balance** of **$125.50**.
3. In the **Control Panel** on the left, select **Contact Treasurer**.
4. Fill in the form:

| Field | Enter or choose |
|---|---|
| Your e-mail | Leave **Use account e-mail: scout@example.org** selected |
| Pay: $ | `25.00` |
| to | Select **Troop 671** |
| For | `Summer camp` |
| Comments | Optional, for example `Thank you` |

5. Select **Send Mail**.
6. The **Confirmation** page says **Thank you. Your message has been sent to the Treasurer.** Under **MESSAGE SUMMARY** it repeats the request.
7. Select **LOGOUT**.

If you leave out **to**, **Pay** or **For**, the form shows a red error for each and sends nothing.

### Step 7: View the e-mail

1. Open [http://localhost:8025/](http://localhost:8025/). Mailpit shows two new messages, one for each Treasurer: `treasurer@example.org` and `assistant@example.org`.
2. Open either one. The subject is **re: Sam Scout's BSA TROOP 671 ISA ACCOUNT**, it comes from `ISA.Troop671@Troop671.com`, and replies go to `scout@example.org`.
3. The message shows the Troop 671 logo, **BSA TROOP 671 ISA WITHDRAWAL REQUEST** with the name, amount, payee and purpose, and a signature line for the withdrawal.

### Step 8: Stop or reset

| To | Type |
|---|---|
| Stop the site and keep its data | `docker compose --env-file Local.env down` |
| Start it again | `docker compose --env-file Local.env up --build --wait` |
| Stop it and erase all its data, returning to the made-up users | `docker compose --env-file Local.env down -v` |

### Sign-in accounts

All of these are made up and exist only on your computer.

| User ID | Password | Role | Notes |
|---|---|---|---|
| `treasurer` | `Treasurer671` | Treasurer | Security question: **Favorite knot?** Answer: `bowline` |
| `assistant` | `Assistant671` | Treasurer | Locked, so it cannot sign in, but it still receives Treasurer e-mail |
| `scout` | `Scout671` | Scout | Security question: **First campout?** Answer: `Philmont` |
| `noquestion` | `Noquestion671` | Scout | Has no security question |
| `locked` | `Locked671` | Scout | Locked |
| `words` | `Words671` | Scout | Its balance is the text **Paid in full** |

Four wrong passwords in a row lock an account, as on the real site. To unlock everything, [reset](#step-8-stop-or-reset) with `down -v`.

### Troubleshooting

| What you see | What to do |
|---|---|
| `docker: command not found`, or `'docker' is not recognized` | Docker Desktop is not installed or not open. Finish [Step 1](#step-1-install-docker-desktop), then open a new terminal. |
| `Cannot connect to the Docker daemon` or `error during connect` | Open Docker Desktop and wait until the engine is running. |
| `couldn't find env file` | The terminal is not in the code folder. Repeat [Step 3](#step-3-open-a-terminal-in-that-folder). |
| `port is already allocated` or `address already in use` | Another program uses port 8671 or 8025. In `Local.env`, change `ISA_HTTP_PORT` or `ISA_MAILPIT_PORT` to another number, such as `8672`, and use that number in the addresses. |
| The browser says the site cannot be reached | The start in [Step 4](#step-4-start-the-site) has not finished, or it stopped with an error. Run it again and read the last lines. |
| **Your account has been locked** | [Reset](#step-8-stop-or-reset) with `down -v`. |
| No message appears in Mailpit | Reload the Mailpit page. The send happens when you select **Send Mail**; the confirmation page says whether it worked. |

## Schema migration

`php bin/MigrateSchema.php` converts `users` to InnoDB and `utf8mb4`, makes `user_id` unique, and creates `account_updates`. Every step checks before it acts, so it can be run again at any time. It prints one JSON line per step.

On the DreamHost host it must run once, before the new pages are deployed, with PHP 8.3 and all of the variables in [Environment variables](#environment-variables) set in its shell: `/usr/local/php83/bin/php ~/troop671.com/ISA/bin/MigrateSchema.php`. The old pages keep working on the migrated schema, because the migration changes only the storage engine, the character set and indexes, and adds a table. That is reasoned from the old code, not tested.

## Settings on the host

`ISA/.htaccess` holds the URL allowlist, which serves only the seven pages and `BSA_Logo.jpg`, and one `SetEnv` line for each variable in [Environment variables](#environment-variables). It contains the database and SMTP passwords, so it is never committed; `bin/WriteHtaccess.php` generates it from the environment of the shell that runs it.

1. Run it on the host after every deploy and after any change to a setting, with PHP 8.3 and every variable set in the shell: `/usr/local/php83/bin/php ~/troop671.com/ISA/bin/WriteHtaccess.php`.
2. Without it, the new pages answer HTTP 500 and log `MissingEnvironment`, and nothing outside the allowlist is blocked.
3. It refuses, exits 1 and keeps the existing file when a value contains a double quote, a backslash, `${` or a character outside printable ASCII, because Apache would change such a value.
4. It writes the file with mode `644`. On the host, `/home/dh_vpjbmy` is `710`, so other accounts cannot read it, and Apache does not serve `.htaccess` files.
5. The local container runs it at every start, and its Apache has no `PassEnv`, so the local stack receives its settings the same way the host does.

## Environment variables

The site reads every setting from the environment and refuses to serve a page when one is missing. Apache passes them to PHP only through `SetEnv` lines in `ISA/.htaccess`; see [Settings on the host](#settings-on-the-host).

| Variable | Meaning |
|---|---|
| `ISA_DATABASE_HOST`, `ISA_DATABASE_PORT`, `ISA_DATABASE_NAME`, `ISA_DATABASE_USER`, `ISA_DATABASE_PASSWORD` | MySQL connection |
| `ISA_SMTP_HOST`, `ISA_SMTP_PORT`, `ISA_SMTP_USER`, `ISA_SMTP_PASSWORD` | SMTP server and login used to send mail |
| `ISA_SMTP_ENCRYPTION` | `smtps` (TLS from the start, port 465), `starttls`, or `none` |
| `ISA_MAIL_FROM_ADDRESS`, `ISA_MAIL_FROM_NAME` | sender of the Treasurer messages |
| `ISA_TREASURER_ADDRESS` | address shown to users for contacting the Treasurer |
| `ISA_SESSION_IDLE_SECONDS` | idle time before a session ends, in seconds |

Compose also reads `ISA_HTTP_PORT`, `ISA_MAILPIT_PORT` and `ISA_MYSQL_ROOT_PASSWORD`. `Local.env` holds local-only values for all of them.

Failures are written to stderr as one JSON object per line.
