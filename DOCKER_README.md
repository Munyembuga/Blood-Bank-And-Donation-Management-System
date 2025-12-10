# Blood Bank and Donation Management System - Docker Setup

## Prerequisites
- Docker Desktop installed on your system
- Docker Compose (included with Docker Desktop)

## Services Included
1. **Web Server** - PHP 8.1 with Apache (Port 8080)
2. **MySQL Database** - MySQL 8.0 (Port 3307)
3. **phpMyAdmin** - Database management tool (Port 8081)

## Quick Start

### 1. Build and Start the Containers
```bash
docker-compose up -d
```

This command will:
- Build the PHP application image
- Start MySQL database container
- Start phpMyAdmin container
- Initialize the database with the SQL schema

### 2. Access the Application
- **Blood Bank Website**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081
  - Server: `db`
  - Username: `root`
  - Password: `bloodbank123`

### 3. Stop the Containers
```bash
docker-compose down
```

### 4. Stop and Remove All Data (including database)
```bash
docker-compose down -v
```

## Docker Commands Reference

### View Running Containers
```bash
docker-compose ps
```

### View Application Logs
```bash
# All services
docker-compose logs

# Specific service
docker-compose logs web
docker-compose logs db
```

### Rebuild Containers (after code changes)
```bash
docker-compose up -d --build
```

### Access Container Shell
```bash
# Web container
docker exec -it bloodbank_web bash

# Database container
docker exec -it bloodbank_db bash
```

### Import SQL Manually (if needed)
```bash
docker exec -i bloodbank_db mysql -uroot -pbloodbank123 blood_donation < sql/blood_bank_database.sql
```

## Configuration

### Database Connection
The application uses environment variables for database connection:
- **Host**: `db` (Docker service name)
- **User**: `root`
- **Password**: `bloodbank123`
- **Database**: `blood_donation`

These are defined in `docker-compose.yml` and automatically used by the application.

### Ports
You can change the ports in `docker-compose.yml`:
```yaml
ports:
  - "8080:80"  # Change 8080 to your preferred port
```

### Database Password
To change the database password, update it in `docker-compose.yml`:
```yaml
environment:
  MYSQL_ROOT_PASSWORD: your_new_password
  DB_PASSWORD: your_new_password
```

## Troubleshooting

### Database Connection Error
If you see "Connection error", wait a few seconds for MySQL to fully initialize:
```bash
docker-compose logs db
```

### Port Already in Use
If ports 8080, 8081, or 3307 are already in use, change them in `docker-compose.yml`.

### Reset Database
```bash
docker-compose down -v
docker-compose up -d
```

### View Real-time Logs
```bash
docker-compose logs -f
```

## Project Structure
```
.
├── Dockerfile              # PHP/Apache container configuration
├── docker-compose.yml      # Multi-container orchestration
├── .dockerignore          # Files to exclude from Docker build
├── conn.php               # Database connection (updated for Docker)
├── admin/conn.php         # Admin database connection (updated for Docker)
├── sql/                   # Database initialization scripts
└── ...                    # Application files
```

## Admin Login
Default admin credentials (as per SQL file):
- **Username**: `varunsardana004`
- **Password**: `123`

## Production Deployment Notes
For production deployment:
1. Change all default passwords
2. Use environment variables file (`.env`)
3. Enable HTTPS with SSL certificates
4. Use Docker secrets for sensitive data
5. Set up proper backup strategies
6. Configure resource limits in docker-compose.yml

## Support
For issues related to:
- **Docker**: Check Docker logs and container status
- **Application**: Check PHP error logs in the web container
- **Database**: Access phpMyAdmin or MySQL container directly
