import { Controller } from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="form" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * form_controller.js -> "form"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        // this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
        console.log("Hello, Stimulus!", this.element)
    }
}
