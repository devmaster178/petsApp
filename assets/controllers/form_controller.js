import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        storageKey: { type: String, default: "select2-session-value" }
    }

    static targets = [
        "type",
        "breed",
        "approximateAge",
        "dateOfBirth",
        "breedOther",
        "input",
        "error"
    ];

    YES = "yes";

    NO = "no";

    MIX = "mix";

    changeBreedUrl(){
        const selectedPetType = this.typeTarget.value;
        const select2Controller = this.application.getControllerForElementAndIdentifier(this.breedTarget, 'select2');
        if (select2Controller && selectedPetType) {
            const newUrl= `/api/breeds?pet_type_id=${selectedPetType}`;
            select2Controller.setUrl(newUrl);
        }
    }

    onHasDobInformationChange(event){
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

    onBreedChoiceChange(event){
        const { value } = event.target;
        if(value === this.MIX){
            this.breedOtherTarget.classList.add('flex');
            this.breedOtherTarget.classList.remove('hidden');
        }else{
            this.breedOtherTarget.classList.add('hidden');
            this.breedOtherTarget.classList.remove('flex');
        }
    }
}
