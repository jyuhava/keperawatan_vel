<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeachingMaterialController extends Controller
{
    /**
     * Show SDKI (Standar Diagnosis Keperawatan Indonesia) guide
     */
    public function panduanSdki()
    {
        $materials = [
            [
                'title' => 'Pengenalan SDKI',
                'description' => 'Panduan dasar tentang Standar Diagnosis Keperawatan Indonesia',
                'content' => 'SDKI merupakan standar diagnosis keperawatan yang dikembangkan khusus untuk Indonesia...',
                'type' => 'introduction'
            ],
            [
                'title' => 'Kategori Diagnosis',
                'description' => 'Memahami berbagai kategori diagnosis dalam SDKI',
                'content' => 'SDKI mengklasifikasikan diagnosis keperawatan ke dalam beberapa kategori utama...',
                'type' => 'category'
            ],
            [
                'title' => 'Contoh Kasus',
                'description' => 'Studi kasus penerapan SDKI dalam praktik keperawatan',
                'content' => 'Berikut adalah contoh-contoh kasus nyata penerapan SDKI...',
                'type' => 'case'
            ]
        ];

        return view('materials.sdki', compact('materials'));
    }

    /**
     * Show SLKI (Standar Luaran Keperawatan Indonesia) materials
     */
    public function materiSlki()
    {
        $materials = [
            [
                'title' => 'Dasar-dasar SLKI',
                'description' => 'Memahami konsep dan prinsip SLKI',
                'content' => 'SLKI adalah standar luaran keperawatan yang mengukur hasil asuhan keperawatan...',
                'type' => 'foundation'
            ],
            [
                'title' => 'Indikator Luaran',
                'description' => 'Mengidentifikasi dan menggunakan indikator luaran SLKI',
                'content' => 'Setiap luaran keperawatan memiliki indikator-indikator terukur...',
                'type' => 'indicator'
            ],
            [
                'title' => 'Evaluasi Luaran',
                'description' => 'Cara mengevaluasi pencapaian luaran keperawatan',
                'content' => 'Evaluasi luaran keperawatan dilakukan dengan mengukur perubahan...',
                'type' => 'evaluation'
            ]
        ];

        return view('materials.slki', compact('materials'));
    }

    /**
     * Show SIKI (Standar Intervensi Keperawatan Indonesia) guide
     */
    public function panduanSiki()
    {
        $materials = [
            [
                'title' => 'Pengenalan SIKI',
                'description' => 'Memahami konsep dan struktur SIKI',
                'content' => 'SIKI adalah standar intervensi keperawatan yang dikembangkan untuk Indonesia...',
                'type' => 'introduction'
            ],
            [
                'title' => 'Tindakan Observasi',
                'description' => 'Panduan tindakan observasi dalam SIKI',
                'content' => 'Tindakan observasi merupakan bagian penting dari intervensi keperawatan...',
                'type' => 'observation'
            ],
            [
                'title' => 'Tindakan Terapeutik',
                'description' => 'Memahami tindakan terapeutik dalam SIKI',
                'content' => 'Tindakan terapeutik bertujuan untuk mengatasi masalah keperawatan...',
                'type' => 'therapeutic'
            ],
            [
                'title' => 'Edukasi dan Kolaborasi',
                'description' => 'Tindakan edukasi dan kolaborasi dalam SIKI',
                'content' => 'Edukasi dan kolaborasi merupakan komponen penting dalam asuhan keperawatan...',
                'type' => 'education'
            ]
        ];

        return view('materials.siki', compact('materials'));
    }
}
