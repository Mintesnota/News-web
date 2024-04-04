import './bootstrap';


//import 'laravel-datatables-vite';

import "datatables.net-editor";
import Editor from "datatables.net-editor-bs5";
Editor(window, $);
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


