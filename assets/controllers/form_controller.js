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
    static targets = [ "type", "breed" ]

    // connect() {
    //     console.log("Hello, Stimulus!", this.element)
    // }

    changeBreedUrl(){
        const selectedPetType = this.typeTarget.value;
        const select2Controller = this.application.getControllerForElementAndIdentifier(this.breedTarget, 'select2');
        if (select2Controller && selectedPetType) {
            const newUrl= `/api/breeds?pet_type_id=${selectedPetType}`;
            select2Controller.setUrl(newUrl);
        }
    }
}
