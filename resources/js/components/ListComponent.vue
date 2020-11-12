<template>
<table class="table align-items-center table-flush">
    <thead class="thead-light">
    <tr>
        <th scope="col">Fragen</th>
        <th scope="col">Antworte</th>
        <th scope="col">Aktion</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="item in qas">
        <td scope="row">
            {{ item.questions }}
        </td>
        <td>
            {{ item.answers }}
        </td>
        <td>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editqaModal">
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
            qas:[]
        }
    },
    mounted() {
        this.getList();
    },
    methods: {
        getList() {
            axios.get('api/v1/getQA').then(response => {
                this.qas = response.data;
            }).catch(e => {
                console.log(e);
            });
        }
    }
}
</script>
