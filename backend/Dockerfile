FROM php:8.2-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    pkg-config \
    && docker-php-ext-install pdo pdo_sqlite

COPY . .

CMD ["php", "-S", "0.0.0.0:8000", "-t", "."]