import { initPsgcLocationSelector } from './modules/psgc-location';
import { initLogoutModal } from './logout';

document.addEventListener('DOMContentLoaded', () => {
    initPsgcLocationSelector();
    initLogoutModal();
});
