# Digital Tolk TMS

## Prerequisites
- Docker
- PHP 8.4+
- Composer 2.8.12
- Node.js 20+
- npm 10+
- SQLite
- Meilisearch 1.19.1

## Setup
1. `git clone`
2. `cp .env.example .env`
3. `read entrypoint.sh file for instructions`
4. `docker compose build`
5. `docker compose up`
6. `visit: http://localhost:8080`

## Local Tooling
- Tests: `composer test`

## Actions Pattern
The application follows an Actions-first architecture under `app/Actions`, where each use case lives in a dedicated class. Controllers stay lean by delegating real work to actions, encouraging single-responsibility logic, making dependencies explicit, and enabling straightforward unit testing.

## Authors

- [@muhammadabdullahmirza](https://www.github.com/muhammadabdullahmirza)

