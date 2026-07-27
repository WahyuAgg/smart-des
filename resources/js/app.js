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

// Inventaris Pages
import kategoriBarangCrud from './pages/kategori-barang';
import lokasiCrud from './pages/lokasi';
import barangCrud from './pages/barang';
import peminjamanCrud from './pages/peminjaman';
import mutasiCrud from './pages/mutasi';

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

window.Alpine = Alpine;
Alpine.start();
