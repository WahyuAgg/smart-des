## Panduan Deployment Khusu Desa curug

php artisan key:generate

### Create Database

windows: type nul > database\database.sqlite 
linux: touch database/database.sqlite

php artisan migrate

php artisan db:seed

### imprt data desa

php artisan import:kk storage/app/private/imports/data_kk.xlsx

php artisan import:penduduk storage/app/private/imports/data_penduduk.xlsx

php artisan import:penduduk storage/app/private/imports/data_penduduk_2.xlsx