# 🧠 TACESSA: Customer Churn Prediction System

<p align="center">
  <img src="https://img.shields.io/badge/Framework-Laravel%2010-%23FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Backend-Flask%20Python-%23000000?style=for-the-badge&logo=flask&logoColor=white" alt="Flask">
  <img src="https://img.shields.io/badge/Algorithm-XGBoost%20%26%20Random%20Forest-%23111111?style=for-the-badge" alt="Algorithms">
  <img src="https://img.shields.io/badge/Institution-Universitas%20Airlangga-blue?style=for-the-badge" alt="UNAIR">
</p>

## 📌 Deskripsi Penelitian
Sistem ini merupakan implementasi perangkat lunak berbasis web dari penelitian tugas akhir/skripsi yang berjudul:  
**"Analisis Komparasi Algoritma Random Forest dan XGBoost untuk Klasifikasi Customer Churn pada Layanan Seluler Prabayar Berbasis Website"**

Sistem **TACESSA** (Tugas Akhir Cessa) dibangun khusus untuk membantu penyedia layanan telekomunikasi dalam memetakan risiko retensi pelanggan secara *real-time* menggunakan pendekatan data science dan machine learning, baik melalui input data manual (*Single Prediction*) maupun unggah berkas massal (*Bulk Prediction*).

---

## 🤵 Informasi Peneliti
* **Nama Peneliti:** Lady Cessa Nadinda
* **NIM:** 434221056
* **Program Studi:** D4 Teknik Informatika (Angkatan 2022)
* **Fakultas:** Vokasi
* **Institusi:** Universitas Airlangga (UNAIR)
* **Dosen Pembimbing:** Rachman Sinatriya Marjianto, B.Eng., M.Sc.

---

## 📊 Hasil Evaluasi & Komparasi Model
Pengujian dilakukan menggunakan baseline **IBM Telco Customer Churn Dataset** (7.043 records) dengan proporsi *data split* 80% Train dan 20% Test (1.409 data uji). Berdasarkan hasil komparasi, **XGBoost ditetapkan sebagai Champion Model** karena unggul pada seluruh metrik evaluasi utama:

| Metrik Evaluasi | XGBoost (Champion Model) 🏆 | Random Forest (Ensemble) |
| :--- | :---: | :---: |
| **Accuracy** | **80.06%** | 77.71% |
| **Precision** | **78.84%** | 76.32% |
| **Recall** | **80.06%** | 77.71% |
| **F1-Score** | **78.74%** | 76.63% |

---

## 🛠️ Arsitektur Teknologi & Spesifikasi
Sistem ini mengadopsi arsitektur *decoupled/micro-framework* untuk memisahkan komputasi berat model AI dengan antarmuka pengguna:
1. **Frontend / Web Portal (Repositori Ini):**
   * **Framework:** Laravel (PHP 8.x) dengan boilerplate scaffolding Laravel Breeze.
   * **Styling Engine:** Tailwind CSS via CDN Core.
   * **Database:** MySQL (sebagai media penyimpanan log riwayat dan kredensial autentikasi pengguna).
   * **Chart Engine:** Chart.js (Radar Chart untuk Visualisasi Evaluasi Model).
2. **Backend / Machine Learning API Server (External):**
   * **Framework:** Flask API (Python 3.9+) sebagai jembatan *deployment* model biner (.pkl).

---

## 🚀 Panduan Instalasi Lokal (Deployment)

### 1. Prasyarat Sistem
* PHP >= 8.1
* Composer
* Laragon / XAMPP (Local Web Server)
* Node.js & NPM (Opsional jika menggunakan asset compiler bawaan)

### 2. Langkah Kloning Proyek
```bash
# Clone repositori ini ke folder root lokal kamu (misal: C:\laragon\www\)
git clone [https://github.com/ldycessa19-blip/web_churn.git](https://github.com/ldycessa19-blip/web_churn.git)
cd web_churn

# Instalasi dependency PHP Laravel
composer install
