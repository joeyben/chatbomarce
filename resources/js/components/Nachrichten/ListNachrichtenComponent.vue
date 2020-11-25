<template>
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
        <tr>
            <th scope="col">Nachricht</th>
            <th scope="col">Position</th>
            <th scope="col">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="item in nachricht">
            <td>
                {{ item.message }}
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
            nachricht:[]
        }
    },
    mounted() {
        console.log("mounted here")
        this.getNachrichten();
    },
    methods: {
        getNachrichten() {
            axios.get('api/v1/getNachricht').then(response => {
                this.nachricht = response.data;
            }).catch(e => {
                console.log(e);
            });
        }
    }
}
</script>
