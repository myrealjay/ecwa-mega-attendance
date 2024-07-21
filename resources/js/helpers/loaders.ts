import { enableAutoUnmount } from '@vue/test-utils';
import { useLoading } from 'vue3-loading-overlay';
import 'vue3-loading-overlay/dist/vue3-loading-overlay.css';

const loader =  useLoading();

export function showLoader() {
    loader.show({
    // Optional parameters
    container: null,
    canCancel: false,
    zIndex:10000,
    color:'#ffffff',
    'background-color': '#000000'
    });
}

export function hideLoader() {
    if (loader) {
        try {
            loader.hide();
        } catch (error) {
            let loader=document.getElementsByClassName('vld-overlay');
            Array.from(loader).forEach((item) => {
                item.classList.remove('is-active');
            });
        }
       
    }
}