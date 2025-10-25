#  Project Management Tool

A modern mini project management tool built with Laravel, Livewire, Jetstream, Breeze, Spatie Permissions, Sanctum, and Laravel Auditing. Features authentication, user roles (Admin/User), project and task CRUD, REST API, activity logs, and a beautiful UI.

---

## Features
- User authentication (Breeze/Jetstream)
- Role-based access (Admin/User)
- Project and Task CRUD (with soft deletes)
- REST API (protected by Sanctum)
- Livewire UI for real-time project/task management
- Activity log (Laravel Auditing, admin-only)
- Feature tests for all major flows

---

## Installation

### Prerequisites
- Docker & Docker Compose (for Laravel Sail)
- Composer

### Steps
1. **Clone the repository:**
   ```sh
   git clone <your-repo-url> project-management-tool
   cd project-management-tool
   ```
2. **Copy the example environment file:**
   ```sh
   cp .env.example .env
   ```
3. **Install dependencies:**
   ```sh
   composer install --no-interaction --prefer-dist
   ```
4. **Build Sail Image (Docker):**
   ```sh
   ./vendor/bin/sail build --no-cache
   ```
5. **Run the Sail (Docker):**
   ```sh
   ./vendor/bin/sail up -d
   ```   
6. **Generate application key:**
   ```sh
   ./vendor/bin/sail artisan key:generate
   ```
7. **Run migrations and seeders:**
   ```sh
   ./vendor/bin/sail artisan migrate --seed
   ```
8. **(Optional) Compile frontend assets:**
   ```sh
   ./vendor/bin/sail npm install && ./vendor/bin/sail npm run dev
   ```
9. **(Optional) Add sd-solutiions to your hostfile:**
10 **Access the app:**
    - Visit [http://sd-solutions](http://localhost) in your browser.

---

## Add Admin seeder command
```sh
 ./vendor/bin/sail artisan user:create "Jane Doe" jane@example.com secret123 Admin
 ```

## Running Tests
```sh
./vendor/bin/sail artisan test
```

---

## Architecture Overview
- **app/Models/**: Eloquent models (User, Project, Task)
- **app/Http/Controllers/**: API controllers
- **app/Http/Livewire/**: Livewire components (UI logic)
- **resources/views/livewire/**: Blade views for Livewire
- **routes/api.php**: REST API routes
- **routes/web.php**: Web routes
- **tests/Feature/**: Feature tests
- **Activity Log**: Only visible to Admins on the dashboard

---

## API Usage
- All API routes are under `/api` and protected by Sanctum.
- Authenticate via `/login` to get a token.
- Example endpoints:
    - `GET /api/projects`
    - `POST /api/projects`
    - `GET /api/tasks`
    - `POST /api/tasks`

---

## Credits
- [Laravel](https://laravel.com/)
- [Livewire](https://laravel-livewire.com/)
- [Jetstream](https://jetstream.laravel.com/)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- [Laravel Auditing](https://laravel-auditing.com/)

---

## License
[MIT](LICENSE)
