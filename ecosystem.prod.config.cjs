module.exports = {
    apps : [{
        name: "dev-tools-prod",
        interpreter: "php",
        // user: 'www-data',
        script: "artisan",
        exec_mode: "fork",
        // instances: "1",
        args: "--env production queue:work --sleep=1",
        autorestart: true,
    }]
}
