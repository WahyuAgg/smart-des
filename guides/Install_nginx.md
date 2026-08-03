# Instalasi Nginx (Ubuntu)

Panduan ini menggunakan Ubuntu 22.04/24.04.

---

## 1. Update Package

```bash
sudo apt update
```

---

## 2. Install Nginx

```bash
sudo apt install nginx -y
```

---

## 3. Cek Status Nginx

```bash
sudo systemctl status nginx
```

Jika berhasil, status akan menjadi:

```
Active: active (running)
```

---

## 4. Menjalankan Nginx

Jika belum berjalan:

```bash
sudo systemctl start nginx
```

Agar otomatis berjalan saat server dinyalakan:

```bash
sudo systemctl enable nginx
```

---

## 5. Memastikan Nginx Berjalan

Buka browser dan akses:

```
http://IP_SERVER
```

atau

```
http://localhost
```

Apabila instalasi berhasil, akan muncul halaman:

```
Welcome to nginx!
```

---

## 6. Perintah yang Sering Digunakan

Menjalankan Nginx

```bash
sudo systemctl start nginx
```

Menghentikan Nginx

```bash
sudo systemctl stop nginx
```

Restart Nginx

```bash
sudo systemctl restart nginx
```

Reload konfigurasi tanpa menghentikan layanan

```bash
sudo systemctl reload nginx
```

Melihat status

```bash
sudo systemctl status nginx
```

---

## 7. Menguji Konfigurasi

Sebelum melakukan reload atau restart, selalu lakukan pengecekan konfigurasi.

```bash
sudo nginx -t
```

Jika berhasil akan muncul output seperti:

```
nginx: the configuration file /etc/nginx/nginx.conf syntax is ok
nginx: configuration file /etc/nginx/nginx.conf test is successful
```

---

## 8. Lokasi Penting

| Lokasi | Keterangan |
|---------|------------|
| `/etc/nginx/nginx.conf` | Konfigurasi utama Nginx |
| `/etc/nginx/sites-available/` | Konfigurasi Virtual Host |
| `/etc/nginx/sites-enabled/` | Virtual Host yang aktif |
| `/var/www/html/` | Root website bawaan |
| `/var/log/nginx/access.log` | Log akses |
| `/var/log/nginx/error.log` | Log error |