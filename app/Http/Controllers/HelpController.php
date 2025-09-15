<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Show user guide
     */
    public function userGuide()
    {
        $guides = [
            [
                'section' => 'Memulai',
                'items' => [
                    'Login ke Sistem',
                    'Navigasi Dashboard', 
                    'Mengatur Profile',
                    'Mengganti Password'
                ]
            ],
            [
                'section' => 'Manajemen Pasien',
                'items' => [
                    'Menambah Data Pasien',
                    'Mengedit Informasi Pasien',
                    'Mencari Data Pasien',
                    'Menghapus Data Pasien'
                ]
            ],
            [
                'section' => 'Proses Keperawatan',
                'items' => [
                    'Melakukan Assessment',
                    'Menetapkan Diagnosis',
                    'Merencanakan Intervensi',
                    'Implementasi Tindakan',
                    'Evaluasi Hasil'
                ]
            ],
            [
                'section' => 'Supervisi (Untuk Dosen)',
                'items' => [
                    'Monitor Progress Mahasiswa',
                    'Review Assessment',
                    'Memberikan Feedback',
                    'Laporan Kemajuan'
                ]
            ]
        ];

        return view('help.user-guide', compact('guides'));
    }

    /**
     * Show FAQ
     */
    public function faq()
    {
        $faqs = [
            [
                'category' => 'Umum',
                'questions' => [
                    [
                        'question' => 'Bagaimana cara mengubah password?',
                        'answer' => 'Masuk ke menu Profile, kemudian pilih "Ubah Password". Masukkan password lama dan password baru Anda.'
                    ],
                    [
                        'question' => 'Bagaimana jika lupa password?',
                        'answer' => 'Klik "Lupa Password" di halaman login, kemudian masukkan email Anda untuk mendapatkan link reset password.'
                    ]
                ]
            ],
            [
                'category' => 'Proses Keperawatan',
                'questions' => [
                    [
                        'question' => 'Apa perbedaan antara SDKI, SLKI, dan SIKI?',
                        'answer' => 'SDKI adalah standar diagnosis, SLKI adalah standar luaran, dan SIKI adalah standar intervensi keperawatan Indonesia.'
                    ],
                    [
                        'question' => 'Bagaimana cara mengedit assessment yang sudah disimpan?',
                        'answer' => 'Buka halaman Assessment, cari assessment yang ingin diedit, kemudian klik tombol "Edit".'
                    ]
                ]
            ],
            [
                'category' => 'Supervisi',
                'questions' => [
                    [
                        'question' => 'Bagaimana dosen dapat memonitor progress mahasiswa?',
                        'answer' => 'Dosen dapat mengakses menu "Monitor Mahasiswa" untuk melihat aktivitas dan progress semua mahasiswa.'
                    ]
                ]
            ]
        ];

        return view('help.faq', compact('faqs'));
    }

    /**
     * Show contact information
     */
    public function contact()
    {
        $contacts = [
            [
                'type' => 'Administrator Sistem',
                'name' => 'Tim IT Keperawatan',
                'email' => 'admin@nursing-app.ac.id',
                'phone' => '(021) 123-4567',
                'description' => 'Untuk masalah teknis dan akses sistem'
            ],
            [
                'type' => 'Koordinator Akademik',
                'name' => 'Dr. Ns. Koordinator',
                'email' => 'koordinator@nursing-app.ac.id',
                'phone' => '(021) 123-4568',
                'description' => 'Untuk pertanyaan akademik dan kurikulum'
            ],
            [
                'type' => 'Support Pembelajaran',
                'name' => 'Tim Support',
                'email' => 'support@nursing-app.ac.id',
                'phone' => '(021) 123-4569',
                'description' => 'Untuk bantuan penggunaan aplikasi'
            ]
        ];

        return view('help.contact', compact('contacts'));
    }
}
