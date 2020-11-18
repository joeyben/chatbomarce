<template>
    <div class="modal fade" id="addfbModal" tabindex="-1" role="dialog" aria-labelledby="addfbModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hinzufügen</h5>
                </div>
                <div class="modal-body">
                    <form action="#" @submit.stop.prevent="handleSubmit">
                        <label for="questionTextarea" class="label_textarea" >Frage:</label><br>
                        <b-form-textarea
                            id="questionTextarea"
                            v-model="questionState"
                            placeholder="Enter something..."
                            rows="3"
                        ></b-form-textarea>
                        <label for="positionTextarea" class="label_textarea">Position:</label><br>
                        <b-form-input
                            id="positionTextarea"
                            v-model="positionState"
                            placeholder="Enter your name"
                            type="number"
                        ></b-form-input>
                        <div class="buttons_form">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                            <button type="submit" class="btn btn-primary" data-backdrop="false">Hinzufügen</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            questionState: '',
            positionState: '',
        }
    },
    methods: {
        handleSubmit() {
            // Exit when the form isn't valid
            /*if (!this.checkFormValidity()) {
                return
            }
            // Push the name to submitted names
            //this.submittedNames.push(this.name)
            // Hide the modal manually
            /*this.$nextTick(() => {
                this.$bvModal.hide('modal-prevent-closing')
            })*/

            axios.post('api/v1/addfb', {
                question: this.questionState,
                position: this.positionState
            }).then(response => {
                $('#addfbModal').modal('hide');
                this.$root.$refs.list.getList();
            }).catch(e => {
                console.log(e);
            });

        }
    }
}
</script>
