<template>
    <div class="modal fade" id="editqaModal" tabindex="-1" role="dialog" aria-labelledby="editqaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                </div>
                <div class="modal-body">
                    <form action="/action_page.php" @submit.stop.prevent="handleSubmit">
                        <label for="questionTextarea" >Frage:</label><br>
                        <b-form-textarea
                            id="questionTextarea"
                            v-model="questionState"
                            placeholder="Enter something..."
                            rows="3"
                        ></b-form-textarea>
                        <label for="answerTextarea">Antwort:</label><br>
                        <b-form-textarea
                            id="answerTextarea"
                            v-model="answerState"
                            placeholder="Enter something..."
                            rows="3"
                        ></b-form-textarea>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Schließen</button>
                        <button type="submit" class="btn btn-primary">Speichern</button>
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
                answerState: '',
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

                axios.post('api/v1/qa', {
                    question: this.questionState,
                    answer: this.answerState
                }).then(response => {
                    this.$bvModal.hide('exampleModalLabel')
                }).catch(e => {
                    console.log(e);
                });

            }
        }
    }
</script>

