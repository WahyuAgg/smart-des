import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

// Services
import { Auth } from './services/auth';
window.Auth = Auth;

// Expose API services globally for inline Alpine components in Blade views
import { barangApi } from './services/barangApi';
import { peminjamanApi } from './services/peminjamanApi';
import { mutasiApi } from './services/mutasiApi';
window.barangApi = barangApi;
window.peminjamanApi = peminjamanApi;
window.mutasiApi = mutasiApi;

// Components
import loginForm from './components/login';
import masterFieldSurat from './pages/master-field-surat';
import kkCrud from './pages/kk';
import pendidikanCrud from './pages/pendidikan';
import jabatanPerangkatCrud from './pages/jabatan-perangkat';
import perangkatDesaCrud from './pages/perangkat-desa';
import pendudukCrud from './pages/penduduk';
import suratWizard from './components/surat-wizard';

// Master Data Baru
import kategoriSuratCrud from './pages/kategori-surat';
import jenisSuratCrud from './pages/jenis-surat';
import dusunCrud from './pages/dusun';
import rwCrud from './pages/rw';
import rtCrud from './pages/rt';

// Inventaris Pages
import kategoriBarangCrud from './pages/kategori-barang';
import lokasiCrud from './pages/lokasi';
import barangCrud from './pages/barang';
import peminjamanCrud from './pages/peminjaman';
import mutasiCrud from './pages/mutasi';

// Dashboard
import dashboard from './pages/dashboard';
import profilDesa from './pages/profil-desa';
import petaDesa from './pages/peta-desa';
import bacaanEdukatif from './pages/bacaan-edukatif';
import bacaanDetail from './pages/bacaan-detail';
import artikelCrud from './pages/artikel-crud';
import galeri from './pages/galeri';
import galeriCrud from './pages/galeri-crud';
import userCrud from './pages/user-crud';
import about from './pages/about';

// Alpine configuration
Alpine.plugin(collapse);

// Global date formatter — accessible as $formatDate(value) in any Alpine expression
import { formatDate } from './utils/date';
Alpine.magic('formatDate', () => formatDate);

Alpine.data('loginForm', loginForm);
Alpine.data('masterFieldSurat', masterFieldSurat);
Alpine.data('kkCrud', kkCrud);
Alpine.data('pendidikanCrud', pendidikanCrud);
Alpine.data('jabatanPerangkatCrud', jabatanPerangkatCrud);
Alpine.data('perangkatDesaCrud', perangkatDesaCrud);
Alpine.data('pendudukCrud', pendudukCrud);
Alpine.data('suratWizard', suratWizard);
Alpine.data('kategoriBarangCrud', kategoriBarangCrud);
Alpine.data('lokasiCrud', lokasiCrud);
Alpine.data('barangCrud', barangCrud);
Alpine.data('peminjamanCrud', peminjamanCrud);
Alpine.data('mutasiCrud', mutasiCrud);

// Dashboard
Alpine.data('dashboard', dashboard);
Alpine.data('profilDesa', profilDesa);
Alpine.data('petaDesa', petaDesa);
Alpine.data('bacaanEdukatif', bacaanEdukatif);
Alpine.data('bacaanDetail', bacaanDetail);
Alpine.data('artikelCrud', artikelCrud);
Alpine.data('galeri', galeri);
Alpine.data('galeriCrud', galeriCrud);
Alpine.data('userCrud', userCrud);
Alpine.data('about', about);

// Master Data Baru
Alpine.data('kategoriSuratCrud', kategoriSuratCrud);
Alpine.data('jenisSuratCrud', jenisSuratCrud);
Alpine.data('dusunCrud', dusunCrud);
Alpine.data('rwCrud', rwCrud);
Alpine.data('rtCrud', rtCrud);

window.Alpine = Alpine;
Alpine.start();
