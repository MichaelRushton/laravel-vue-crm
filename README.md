# Laravel Vue CRM

A CRM built in Laravel and Vue.

## Installation

```bash
git clone git@github.com:MichaelRushton/laravel-vue-crm.git . && bin/app install
```

The app will be accessible at http://localhost and the [Mailpit](https://mailpit.axllent.org/) dashboard at http://localhost:8025.

Database connection details:

Host: 127.0.0.1\
Port: 5432\
Database: db\
Username: postgres\
Password:

## Commands

```bash
bin/app help                List available commands
bin/app install             Install the app
bin/app start               Start the Docker containers
bin/app stop                Stop the Docker containers
bin/app dev                 Clear cache and watch for changes
bin/app format              Run Prettier and Laravel Pint
bin/app npm [command]       Run an npm command
bin/app php [command]       Run a php command
bin/app composer [command]  Run a composer command
bin/app vendor [executable] Run a vendor/bin executable
bin/app artisan [command]   Run an artisan command
bin/app [command]           Run an artisan command (shorthand)
```
