import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [
        "type",
        "breed",
        "approximateAge",
        "dateOfBirth"
    ];

    YES = "yes";

    NO = "no";

    changeBreedUrl(){
        const selectedPetType = this.typeTarget.value;
        const select2Controller = this.application.getControllerForElementAndIdentifier(this.breedTarget, 'select2');
        if (select2Controller && selectedPetType) {
            const newUrl= `/api/breeds?pet_type_id=${selectedPetType}`;
            select2Controller.setUrl(newUrl);
        }
    }

    onDobChoiceChange(event){
        const { value } = event.target;
        if(value === this.YES){
            this.dateOfBirthTarget.classList.remove('hidden');
            this.approximateAgeTarget.classList.add('hidden');
        }

        if(value === this.NO){
            this.dateOfBirthTarget.classList.add('hidden');
            this.approximateAgeTarget.classList.remove('hidden');
        }
    }
}
