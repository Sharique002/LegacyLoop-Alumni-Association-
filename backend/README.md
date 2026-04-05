# LegacyLoop Alumni Platform - Laravel Backend

## Overview
This is the PHP Laravel backend API for the LegacyLoop Alumni Association Platform. It provides a comprehensive RESTful API for managing alumni connections, job postings, events, donations, success stories, and networking features.

## Requirements
- PHP >= 8.1
- Composer
- MySQL >= 8.0 or PostgreSQL >= 13
- Redis (optional, for caching and queues)

## Installation

### 1. Install Dependencies
```bash
cd backend
composer install
```

### 2. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=legacyloop
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. Database Setup
```bash
# Create database
mysql -u root -p
CREATE DATABASE legacyloop;

# Run migrations
php artisan migrate

# Seed database with predefined users for all departments
php artisan db:seed
```

### 🎓 Predefined Test Users for All Departments

The database includes pre-seeded users for each department ready for quick testing.

#### Test Login Credentials

| Email | Password | Department |
|-------|----------|------------|
| **john@legacyloop.in** | **John123** | Computer Science |
| student.cs@legacyloop.in | LegacyLoop@123 | Computer Science |
| student.it@legacyloop.in | LegacyLoop@123 | Information Technology |
| student.me@legacyloop.in | LegacyLoop@123 | Mechanical Engineering |
| student.civil@legacyloop.in | LegacyLoop@123 | Civil Engineering |
| student.ee@legacyloop.in | LegacyLoop@123 | Electrical Engineering |
| student.ec@legacyloop.in | LegacyLoop@123 | Electronics Engineering |
| student.ch@legacyloop.in | LegacyLoop@123 | Chemical Engineering |

**Quick Test:**
```bash
# After starting the server
# Go to: http://localhost:8000/login
# Email: john@legacyloop.in
# Password: John123
```

**To seed only predefined users:**
```bash
php artisan db:seed --class=PredefinedUsersSeeder
```

### 4. Generate JWT Secret (if using JWT)
```bash
php artisan jwt:secret
```

### 5. Start Development Server
```bash
php artisan serve
```

API will be available at: `http://localhost:8000/api`

## Project Structure

```
backend/
├── app/
│   ├── Console/
│   │   └── Kernel.php
│   ├── Exceptions/
│   │   └── Handler.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php
│   │   │   └── Api/
│   │   │       ├── AuthController.php
│   │   │       ├── AlumniController.php
│   │   │       ├── JobController.php
│   │   │       ├── EventController.php
│   │   │       ├── SuccessStoryController.php
│   │   │       ├── DonationController.php
│   │   │       ├── NetworkingController.php
│   │   │       └── AdminController.php
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php
│   │   │   ├── AdminMiddleware.php
│   │   │   ├── TrimStrings.php
│   │   │   └── TrustProxies.php
│   │   └── Kernel.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Job.php
│   │   ├── JobApplication.php
│   │   ├── Event.php
│   │   ├── EventAttendee.php
│   │   ├── SuccessStory.php
│   │   ├── Donation.php
│   │   ├── Connection.php
│   │   ├── Message.php
│   │   ├── MentorshipProgram.php
│   │   ├── Notification.php
│   │   ├── Comment.php
│   │   └── Like.php
│   └── Providers/
│       ├── AppServiceProvider.php
│       ├── AuthServiceProvider.php
│       ├── EventServiceProvider.php
│       └── RouteServiceProvider.php
├── bootstrap/
│   └── app.php
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── cors.php
│   └── database.php
├── database/
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_users_table.php
│   │   ├── 2024_01_01_000002_create_password_reset_tokens_table.php
│   │   ├── 2024_01_01_000003_create_jobs_table.php
│   │   ├── 2024_01_01_000004_create_job_applications_table.php
│   │   ├── 2024_01_01_000005_create_events_table.php
│   │   ├── 2024_01_01_000006_create_event_attendees_table.php
│   │   ├── 2024_01_01_000007_create_success_stories_table.php
│   │   ├── 2024_01_01_000008_create_donations_table.php
│   │   ├── 2024_01_01_000009_create_connections_table.php
│   │   ├── 2024_01_01_000010_create_messages_table.php
│   │   ├── 2024_01_01_000011_create_mentorship_programs_table.php
│   │   ├── 2024_01_01_000012_create_notifications_table.php
│   │   ├── 2024_01_01_000013_create_comments_table.php
│   │   ├── 2024_01_01_000014_create_likes_table.php
│   │   └── 2024_01_01_000015_create_permission_tables.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── RoleSeeder.php
├── public/
│   └── index.php
├── routes/
│   ├── api.php
│   ├── console.php
│   └── web.php
├── .env.example
├── artisan
└── composer.json
```

## API Endpoints

### Authentication
- `POST /api/register` - Register new user
- `POST /api/login` - Login user
- `POST /api/logout` - Logout (authenticated)
- `GET /api/me` - Get current user (authenticated)
- `PUT /api/profile` - Update profile (authenticated)
- `POST /api/change-password` - Change password (authenticated)

### Alumni Directory
- `GET /api/alumni` - Get all alumni (with filters)
- `GET /api/alumni/{id}` - Get single alumni profile
- `GET /api/alumni/statistics` - Get alumni statistics

### Jobs
- `GET /api/jobs` - Get all jobs (with filters)
- `GET /api/jobs/{id}` - Get single job
- `POST /api/jobs` - Create job (authenticated)
- `PUT /api/jobs/{id}` - Update job (authenticated)
- `DELETE /api/jobs/{id}` - Delete job (authenticated)
- `POST /api/jobs/{id}/apply` - Apply for job (authenticated)
- `GET /api/my-applications` - Get user's applications (authenticated)
- `GET /api/jobs/{id}/applications` - Get job applications (authenticated)

### Events
- `GET /api/events` - Get all events (with filters)
- `GET /api/events/{id}` - Get single event
- `POST /api/events` - Create event (authenticated)
- `PUT /api/events/{id}` - Update event (authenticated)
- `DELETE /api/events/{id}` - Delete event (authenticated)
- `POST /api/events/{id}/register` - Register for event (authenticated)
- `POST /api/events/{id}/cancel` - Cancel registration (authenticated)
- `GET /api/my-events` - Get user's events (authenticated)

### Success Stories
- `GET /api/stories` - Get all success stories (with filters)
- `GET /api/stories/{id}` - Get single story
- `POST /api/stories` - Create story (authenticated)
- `PUT /api/stories/{id}` - Update story (authenticated)
- `DELETE /api/stories/{id}` - Delete story (authenticated)
- `POST /api/stories/{id}/like` - Like/unlike story (authenticated)
- `GET /api/my-stories` - Get user's stories (authenticated)

### Donations
- `GET /api/donations` - Get all donations
- `GET /api/donations/statistics` - Get donation statistics
- `POST /api/donations` - Create donation (authenticated)
- `GET /api/my-donations` - Get user's donations (authenticated)

### Networking
- `GET /api/connections` - Get all connections (authenticated)
- `GET /api/connection-requests` - Get pending requests (authenticated)
- `POST /api/connections/send` - Send connection request (authenticated)
- `POST /api/connections/{id}/accept` - Accept request (authenticated)
- `POST /api/connections/{id}/reject` - Reject request (authenticated)
- `GET /api/messages` - Get all conversations (authenticated)
- `GET /api/messages/{userId}` - Get conversation with user (authenticated)
- `POST /api/messages` - Send message (authenticated)
- `DELETE /api/messages/{id}` - Delete message (authenticated)
- `GET /api/messages/unread/count` - Get unread count (authenticated)

### Admin (requires admin role)
- `GET /api/admin/dashboard` - Get dashboard statistics
- `GET /api/admin/users` - Get all users
- `POST /api/admin/users/{id}/toggle-status` - Toggle user status
- `POST /api/admin/users/{id}/role` - Update user role
- `GET /api/admin/stories/pending` - Get pending stories
- `POST /api/admin/stories/{id}/approve` - Approve story
- `POST /api/admin/stories/{id}/reject` - Reject story
- `GET /api/admin/activities` - Get recent activities
- `GET /api/admin/analytics` - Get analytics data

## Authentication

This API uses Laravel Sanctum for authentication. After logging in, you'll receive an access token that should be included in the `Authorization` header of subsequent requests:

```
Authorization: Bearer {your_access_token}
```

## Response Format

All API responses follow this format:

### Success Response
```json
{
  "success": true,
  "message": "Operation successful",
  "data": { ... }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message",
  "errors": { ... }
}
```

## Database Models

### User
- Profile information (name, email, avatar, bio)
- Academic info (graduation year, degree, branch)
- Professional info (company, job title, skills)
- Location & social links
- Privacy settings

### Job
- Job details (title, description, requirements)
- Company information
- Salary range & type
- Location & remote options
- Application tracking

### Event
- Event details (title, description, type)
- Date & time
- Location (physical/virtual/hybrid)
- Registration management
- Attendance tracking

### Success Story
- Story content & media
- Category & tags
- Publication status
- Engagement metrics

### Donation
- Amount & currency
- Campaign details
- Payment processing
- Recognition levels

### Connection & Message
- Alumni networking
- Connection requests
- Real-time messaging
- Conversation history

## Roles & Permissions

### Admin Role
- Full access to all features
- User management
- Content moderation
- Analytics access

### Alumni Role
- Post jobs & events
- Apply for jobs
- Register for events
- Create success stories
- Donate
- Network with other alumni
- Send messages

## Testing

```bash
# Run tests
php artisan test

# Run specific test
php artisan test --filter=AuthTest
```

## Production Deployment

### 1. Optimize Application
```bash
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Set Environment
```bash
APP_ENV=production
APP_DEBUG=false
```

### 3. Set Up Queue Worker (optional)
```bash
php artisan queue:work --daemon
```

### 4. Set Up Task Scheduler (optional)
Add to crontab:
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

## Security

- All sensitive routes protected with authentication
- Admin routes require admin role
- CORS configured for frontend access
- Password hashing with bcrypt
- SQL injection protection via Eloquent ORM
- CSRF protection enabled

## License

MIT License

## Support

For issues or questions, please contact the development team or create an issue in the repository.
