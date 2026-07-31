## Panduan Deployment Khusu Desa curug

php artisan key:generate

### Create Database

windows: type nul > database\database.sqlite 
linux: touch database/database.sqlite


php artisan migrate

php artisan laravolt:indonesia:seed


php artisan db:seed

### imprt data desa

php artisan import:kk storage/app/private/imports/data_kk.xlsx

php artisan import:penduduk storage\app\private\imports\data_penduduk_21.xlsx

php artisan import:penduduk storage\app\private\imports\data_penduduk_25.xlsx


### Testing

php artisan db:seed --class="Database\Seeders\TestingSrtSeeder\RefPerangkatDesaSeeder"