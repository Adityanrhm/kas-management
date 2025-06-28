# Manajemen Uang Kas  
Aplikasi web untuk manajemen keuangan kas sederhana.

---

## Project Overview

Berikut beberapa screenshot aplikasi manajemen kas:

| <img src="https://raw.githubusercontent.com/Adityanrhm/kas-management/dev/overview/login.png" alt="Dashboard" width="400" /> | <img src="https://via.placeholder.com/400x200.png?text=Transaksi" alt="Transaksi" width="400" /> |
|:---:|:---:|
| Login UI | Menu transaksi kas |

| <img src="https://via.placeholder.com/400x200.png?text=Laporan" alt="Laporan" width="800" /> |
|:---:|
| Laporan keuangan kas |


---


## Fitur Utama [WORK IN PROGRESS]

- **Manajemen Transaksi Kas**: Catat pemasukan dan pengeluaran kas.
- **Dashboard Ringkasan**: Lihat saldo, total pemasukan, dan pengeluaran 
- **Laporan Bulanan**: Laporan keuangan per-bulan.
- **Responsive Design**: Tampilan ramah di berbagai perangkat.
- **Interaktif dengan Alpine.js**: UI dinamis
- **Styling Modern dengan Tailwind CSS**: Tampilan elegan.

---

## Tech Stack
  
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=black)
![Vite](https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white)


---
## License

This project is licensed under the [MIT License](LICENSE)


---

## Kontribusi

Open issue or pull request.


## Instalasi & Penggunaan

1. Clone the repository
```
git clone https://github.com/Adityanrhm/kas-management.git
cd kas-management
```
2. Install dependency
```
npm install && npm update && npm audit fix
composer update && composer install
```
3. Setup Environment
```
cp .env.example .env
php artisan key:generate
```
4. Migrate database
```
php artisan migrate
php artisan storage:link
```
5. Run build & server
```
npm run build
php artisan serve
```
6. Everything at once
```
git clone https://github.com/Adityanrhm/kas-management.git && cd kas-management && npm install \
&& npm update && npm audit fix && composer update && composer install && cp .env.example .env \
&& php artisan key:generate && php artisan migrate && php artisan storage:link && php artisan migrate \
php artisan storage:link && npm run build && php artisan serve
```

---

<p align="center">
  <span style="font-size: 24px; font-weight: bold;">
    made with ❤️,
 Developed by Adityanrhm x khzx
  </span>
</p>

