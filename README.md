# Attendance App

A web-based attendance management system built with PHP, MySQL, and Docker. This application allows faculty members to manage student attendance with Google OAuth integration for secure authentication.

## Features

- **Google OAuth Authentication**: Secure login using Google accounts (restricted to @srmist.edu.in domain)
- **Attendance Management**: Mark and track student attendance
- **Faculty Dashboard**: View and manage attendance records
- **Course Registration**: Handle course enrollments and student registrations
- **Session Management**: Organize attendance by sessions and courses
- **Export Functionality**: Export attendance reports to CSV
- **Responsive UI**: Modern, dark-mode enabled interface using Tailwind CSS

## Tech Stack

- **Backend**: PHP 7.4
- **Database**: MySQL 5.7
- **Web Server**: Apache
- **Frontend**: HTML, CSS (Tailwind CSS), JavaScript (jQuery)
- **Authentication**: Google OAuth 2.0 (via league/oauth2-google)
- **Containerization**: Docker & Docker Compose
- **Database Management**: phpMyAdmin

## Prerequisites

- Docker
- Docker Compose
- Google OAuth 2.0 Client ID (for authentication)

## Installation

### 1. Clone the Repository

```bash
git clone https://github.com/kulharshit21/AttendenceApp.git
cd AttendenceApp
```

### 2. Configure Google OAuth

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select an existing one
3. Enable Google+ API
4. Create OAuth 2.0 credentials
5. Add authorized JavaScript origins and redirect URIs
6. Copy your Client ID and update it in `index.php` (line 122)

### 3. Start the Application

```bash
docker-compose up -d
```

This will start three services:
- **Web Server**: Apache with PHP on `http://localhost:8080`
- **MySQL Database**: MySQL 5.7 on port `3306`
- **phpMyAdmin**: Database management UI on `http://localhost:8081`

### 4. Initialize the Database

1. Access phpMyAdmin at `http://localhost:8081`
   - Username: `root`
   - Password: `rootpassword`

2. Create the required database and tables by running the SQL scripts in the `database/` folder or access:
   ```
   http://localhost:8080/database/createtables.php
   ```

### 5. Access the Application

Open your browser and navigate to:
```
http://localhost:8080
```

## Project Structure

```
AttendenceApp/
├── ajaxhandler/           # AJAX request handlers
│   ├── attendanceAJAX.php
│   ├── loginAjax.php
│   └── logoutAjax.php
├── css/                   # Stylesheets
│   ├── attendance.css
│   ├── bootstrap.min.css
│   ├── loader.css
│   └── login.css
├── database/              # Database utilities
│   ├── attendanceDetails.php
│   ├── courseRegistrationDetails.php
│   ├── createtables.php
│   ├── database.php
│   ├── facultyDetails.php
│   └── sessionDetails.php
├── js/                    # JavaScript files
│   ├── attendance.js
│   ├── jquery.js
│   └── login.js
├── vendor/                # Composer dependencies
├── .gitignore
├── attendance.php         # Main attendance page
├── composer.json          # PHP dependencies
├── docker-compose.yml     # Docker configuration
├── Dockerfile             # Docker image definition
├── index.php              # Login page
└── README.md
```

## Configuration

### Database Configuration

Default database credentials (can be modified in `docker-compose.yml`):
- **Host**: `db` (or `localhost` from host machine)
- **Port**: `3306`
- **Database**: `mydatabase`
- **Username**: `user`
- **Password**: `password`
- **Root Password**: `rootpassword`

Update database connection settings in `database/database.php` if needed.

### Environment Variables

You can customize the following in `docker-compose.yml`:
- `MYSQL_ROOT_PASSWORD`: MySQL root password
- `MYSQL_DATABASE`: Default database name
- `MYSQL_USER`: MySQL user
- `MYSQL_PASSWORD`: MySQL user password

## Usage

### For Faculty/Admin

1. **Login**: Sign in using your @srmist.edu.in Google account
2. **Dashboard**: View all registered courses and sessions
3. **Mark Attendance**: Select a session and mark students as present/absent
4. **View Reports**: Export attendance data to CSV for analysis
5. **Manage Sessions**: Create and manage attendance sessions

### API Endpoints

- `POST /ajaxhandler/loginAjax.php` - Handle Google OAuth login
- `POST /ajaxhandler/attendanceAJAX.php` - Manage attendance operations
- `POST /ajaxhandler/logoutAjax.php` - Handle user logout

## Docker Commands

### Start the application
```bash
docker-compose up -d
```

### Stop the application
```bash
docker-compose down
```

### View logs
```bash
docker-compose logs -f
```

### Rebuild containers
```bash
docker-compose up -d --build
```

### Access MySQL CLI
```bash
docker exec -it mysql_db mysql -u root -p
```

## Security Notes

- Google OAuth is configured to accept only `@srmist.edu.in` email addresses
- Update the Google Client ID in production
- Change default database passwords in production
- Ensure proper file permissions on the server
- Use HTTPS in production environments

## Dependencies

### PHP Packages (Composer)
- `league/oauth2-google`: ^4.0 - Google OAuth 2.0 provider

### Frontend Libraries
- Tailwind CSS (via CDN)
- jQuery 3.6.0 (via CDN)
- Google Sign-In API

## Troubleshooting

### Database Connection Issues
- Ensure MySQL container is running: `docker ps`
- Check database credentials in `database/database.php`
- Verify network connectivity between containers

### Google OAuth Not Working
- Verify Client ID is correctly configured
- Check authorized JavaScript origins in Google Console
- Ensure email domain restriction is properly set

### Port Conflicts
If ports 8080, 8081, or 3306 are already in use:
1. Stop conflicting services
2. Or modify port mappings in `docker-compose.yml`

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is open source and available for educational purposes.

## Contact

Project Link: [https://github.com/kulharshit21/AttendenceApp](https://github.com/kulharshit21/AttendenceApp)

## Acknowledgments

- Google OAuth 2.0 for authentication
- Tailwind CSS for styling
- Docker for containerization
- League OAuth2 Client for PHP OAuth implementation
