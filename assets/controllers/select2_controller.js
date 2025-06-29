import {Controller} from '@hotwired/stimulus';
import $ from 'jquery';
import 'select2';

export default class extends Controller {
    static values = {
        url: String,
        placeholder: String
    };

    connect() {
        const select2 = this.initializeSelect2();
        select2.on('select2:select', this.onSelect.bind(this));
    }

    initializeSelect2() {
        return $(this.element).select2({
            ajax: {
                url: () => this.urlValue,
                dataType: 'json',
                delay: 250,
                data: (params) => ({
                    search: params.term,
                    page: params.page || 1,
                    pet_type_id: params.pet_type_id,
                }),
                processResults: (data) => ({
                    results: data.items,
                    pagination: {
                        more: data.hasMore
                    }
                }),
                cache: true
            },
            placeholder: this.placeholderValue || 'Select an option',
            minimumInputLength: 1,
            width: '100%',
            templateResult: (item) => item.loading ? item.text : `${item.text}`,
            templateSelection: (item) => item.text
        });
    }

    /**
     * Force reload with the new url
     */
    reload() {
        $(this.element).val(null).trigger('change');
        $(this.element).select2('destroy');
        this.initializeSelect2();
    }

    setUrl(newUrl) {
        this.urlValue = newUrl;
        this.reload();
    }

    onSelect(event) {
        const selectedData = event.params.data;
        console.log('Selected:', selectedData);
        if(!selectedData.id){
            this.show('#breedsChoice');
        }else{
            this.hide('#breedsChoice');
        }
    }

    show(selector) {
        const el = document.querySelector(selector);
        if (el) el.classList.remove('hidden');
    }

    hide(selector) {
        const el = document.querySelector(selector);
        if (el) el.classList.add('hidden');
    }
}
