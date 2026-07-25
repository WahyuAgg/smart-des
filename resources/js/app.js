import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

// Services
import { Auth } from './services/auth';
window.Auth = Auth;

// Components
import loginForm from './components/login';
import masterFieldSurat from './pages/master-field-surat';
import kkCrud from './pages/kk';
import pendidikanCrud from './pages/pendidikan';
import jabatanPerangkatCrud from './pages/jabatan-perangkat';
import perangkatDesaCrud from './pages/perangkat-desa';
import pendudukCrud from './pages/penduduk';
import suratWizard from './components/surat-wizard';

// Alpine configuration
Alpine.plugin(collapse);

Alpine.data('loginForm', loginForm);
Alpine.data('masterFieldSurat', masterFieldSurat);
Alpine.data('kkCrud', kkCrud);
Alpine.data('pendidikanCrud', pendidikanCrud);
Alpine.data('jabatanPerangkatCrud', jabatanPerangkatCrud);
Alpine.data('perangkatDesaCrud', perangkatDesaCrud);
Alpine.data('pendudukCrud', pendudukCrud);
Alpine.data('suratWizard', suratWizard);

window.Alpine = Alpine;
Alpine.start();
