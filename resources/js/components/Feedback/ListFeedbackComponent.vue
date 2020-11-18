<template>
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
        <tr>
            <th scope="col">Frage</th>
            <th scope="col">Position</th>
            <th scope="col">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in feedback">
            <td>
                {{ item.question }}
            </td>
            <td>
                {{ item.position }}
            </td>

            <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editfbModal">
                    Editieren
                </button>

                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#questionAnswerModal">
                    Löschen
                </button>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
import axios from 'axios';
export default {
    data(){
        return {
            feedback:[]
        }
    },
    mounted() {
        console.log("mounted here")
        this.getFeedbackList();
    },
    methods: {
        getFeedbackList() {
            axios.get('api/v1/getfeedback').then(response => {
                this.feedback = response.data;
            }).catch(e => {
                console.log(e);
            });
        }
    }
}
</script>
