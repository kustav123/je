<?php
// install.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appName = $_POST['app_name'] ?? '';
    $appEnv = $_POST['app_env'] ?? '';
    $dbConnection = $_POST['db_connection'] ?? '';
    $dbHost = $_POST['db_host'] ?? '';
    $dbPort = $_POST['db_port'] ?? '';
    $dbDatabase = $_POST['db_database'] ?? '';
    $dbUsername = $_POST['db_username'] ?? '';
    $dbPassword = $_POST['db_password'] ?? '';
    $timezone = $_POST['timezone'] ?? '';
    $sessionDriver = $_POST['session_driver'] ?? 'file';
    $sessionLifetime = $_POST['session_lifetime'] ?? '120';
    $cacheDriver = $_POST['cache_driver'] ?? 'file';
    $cacheStore = $_POST['cache_store'] ?? 'file';
    $cachePrefix = $_POST['cache_prefix'] ?? 'ssm';
    $redisClient = $_POST['redis_client'] ?? 'phpredis';
    $redisHost = $_POST['redis_host'] ?? '127.0.0.1';
    $redisPassword = $_POST['redis_password'] ?? '';
    $redisPort = $_POST['redis_port'] ?? '6379';

    // Basic validation
    if (!$appName || !$appEnv || !$dbConnection || !$dbHost || !$dbPort || !$dbDatabase || !$dbUsername || !$timezone) {
        echo 'All fields are required!';
        exit;
    }

    // Generate a random application key
    $appKey = base64_encode(random_bytes(32));

    // Create .env content
    $envContent = "
APP_NAME=\"$appName\"
APP_ENV=$appEnv
APP_KEY=base64:$appKey
APP_DEBUG=true
APP_URL=http://localhost
APP_TIMEZONE=$timezone

DB_CONNECTION=$dbConnection
DB_HOST=$dbHost
DB_PORT=$dbPort
DB_DATABASE=$dbDatabase
DB_USERNAME=$dbUsername
DB_PASSWORD=$dbPassword

SESSION_DRIVER=$sessionDriver
SESSION_LIFETIME=$sessionLifetime
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

CACHE_DRIVER=$cacheDriver
CACHE_STORE=$cacheStore
CACHE_PREFIX=$cachePrefix

REDIS_CLIENT=$redisClient
REDIS_HOST=$redisHost
REDIS_PASSWORD=$redisPassword
REDIS_PORT=$redisPort
";

    // Write the .env file
    file_put_contents(__DIR__ . '/../../.env', trim($envContent));

    // Create an installation flag file
    $artisanPath = __DIR__ . '/../../artisan'; // Adjust the path based on your directory structure


    exec("php $artisanPath  artisan optimize:clear", $output, $returnVar);

    exec("php $artisanPath migrate:fresh --seed --force", $output, $returnVar);

    if ($returnVar !== 0) {
        echo 'Error running migrations and seeders: ' . implode("\n", $output);
        exit;
    }
    file_put_contents(__DIR__ . '/installed.flag', '');

    echo 'Application installed successfully!';
} else {
    if (file_exists(__DIR__ . '/installed.flag')) {
        echo 'Application is already installed!';
        exit;
    }
        ?>
   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install Application</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Install Application</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="app_name" class="form-label">Application Name</label>
                <input type="text" class="form-control" id="app_name" name="app_name" required>
            </div>

            <div class="mb-3">
                <label for="app_env" class="form-label">Environment</label>
                <select class="form-select" id="app_env" name="app_env" required>
                    <option value="local">Local</option>
                    <option value="production">Production</option>
                    <option value="staging">Staging</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="db_connection" class="form-label">Database Connection</label>
                <select class="form-select" id="db_connection" name="db_connection" required>
                    <option value="mysql">MySQL</option>
                    <option value="pgsql">PostgreSQL</option>
                    <option value="sqlite">SQLite</option>
                    <option value="sqlsrv">SQL Server</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="db_host" class="form-label">Database Host</label>
                <input type="text" class="form-control" id="db_host" name="db_host" required>
            </div>
            <div class="mb-3">
                <label for="db_port" class="form-label">Database Port</label>
                <input type="text" class="form-control" id="db_port" name="db_port" required>
            </div>
            <div class="mb-3">
                <label for="db_database" class="form-label">Database Name</label>
                <input type="text" class="form-control" id="db_database" name="db_database" required>
            </div>
            <div class="mb-3">
                <label for="db_username" class="form-label">Database Username</label>
                <input type="text" class="form-control" id="db_username" name="db_username" required>
            </div>
            <div class="mb-3">
                <label for="db_password" class="form-label">Database Password</label>
                <input type="password" class="form-control" id="db_password" name="db_password">
            </div>
            <div class="mb-3">
                <label for="timezone" class="form-label">Timezone</label>
                <input type="text" class="form-control" id="timezone" name="timezone" value="Asia/Kolkata" required>
            </div>
            <div class="mb-3">
                <label for="session_driver" class="form-label">Session Driver</label>
                <select class="form-select" id="session_driver" name="session_driver" required>
                    <option value="file" selected>File</option>
                    <option value="database">Database</option>
                    <option value="redis">Redis</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="session_lifetime" class="form-label">Session Lifetime (minutes)</label>
                <input type="number" class="form-control" id="session_lifetime" name="session_lifetime" value="120" required>
            </div>
            <div class="mb-3">
                <label for="cache_driver" class="form-label">Cache Driver</label>
                <select class="form-select" id="cache_driver" name="cache_driver" required>
                    <option value="file" selected>File</option>
                    <option value="database">Database</option>
                    <option value="redis">Redis</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cache_store" class="form-label">Cache Store</label>
                <select class="form-select" id="cache_store" name="cache_store" required>
                    <option value="file" selected>File</option>
                    <option value="database">Database</option>
                    <option value="redis">Redis</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="redis_client" class="form-label">Redis Client</label>
                <select class="form-select" id="redis_client" name="redis_client" required>
                    <option value="predis">predis</option>
                    <option value="phpredis" selected>phpredis</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="cache_prefix" class="form-label">Cache Prefix</label>
                <input type="text" class="form-control" id="cache_prefix" name="cache_prefix" value="ssm" required>
            </div>

            <div class="mb-3">
                <label for="redis_host" class="form-label">Redis Host</label>
                <input type="text" class="form-control" id="redis_host" name="redis_host" value="127.0.0.1" required>
            </div>
            <div class="mb-3">
                <label for="redis_password" class="form-label">Redis Password</label>
                <input type="text" class="form-control" id="redis_password" name="redis_password">
            </div>
            <div class="mb-3">
                <label for="redis_port" class="form-label">Redis Port</label>
                <input type="number" class="form-control" id="redis_port" name="redis_port" value="6379" required>
            </div>
            <button type="submit" class="btn btn-primary">Install</button>
        </form>
    </div>
    <script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>

    <?php
}
