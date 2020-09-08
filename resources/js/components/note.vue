<template>
<div>
    <b-modal id="modal-prevent-closing" ref="modal" title="New Note" @cancel="cancel" @ok="save">
        <textarea class="form-control" placeholder="Content" v-model="content" rows="3"></textarea>
    </b-modal>
    <div class="header">
        <b-button v-b-modal.modal-prevent-closing class="btn btn-success btn-sm shadow-sm border border-0">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </b-button>
        <span>Notes : {{total}}</span>
        {{errors.content}}
    </div>
    <hr>
    <div class="card shadow-sm noteborder m-2" v-for="(note, id) in notes" :key="note.id">
        <div class="card-body">
            {{note.content}}
            <a class="btn btn-outline-danger shadow-sm btn-sm float-right border border-0" @click="deletenote(note.id) || $event.target.classList.toggle('disabled')">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    <div class="card shadow-sm notfound noteborder" v-if="notes.length==0">
        <div class="card-body text-center  ">
            Not Found Notes
        </div>
    </div>
    <div v-if="lastpage>1">
        <a class="btn btn-light shadow-sm float-left ml-5 mr-5" @click="changepage(first)">First</a>
        <a class="btn btn-light shadow-sm float-left ml-5 mr-5" @click="changepage(prev)">Prev</a>
        <a class="btn btn-primary shadow-sm">{{current}}</a>
        <a class="btn btn-light shadow-sm float-right ml-5 mr-5" @click="changepage(last)">Last</a>
        <a class="btn btn-light shadow-sm float-right ml-5 mr-5" @click="changepage(next)">Next</a>
    </div>
</div>
</template>

<script>
import filters from "../filters.js";
export default {
    component: [],
    props: ['project'],
    data() {
        return {
            notes: [],
            errors: {},
            content: '',
            total: 0,
            next: null,
            prev: null,
            first: null,
            last: null,
            current: null,
            lastpage: null,
        }
    },
    methods: {
        save() {
            axios.post('/note', {
                    content: this.content,
                    project_id: this.project.id
                })
                .then(response => {
                    this.content = '',
                        this.allnote();
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        },
        allnote() {
            axios.get('/note/' + this.project.id + '?page=' + this.current)
                .then(response => {
                    this.pagination(response.data);
                    this.$emit('comment');
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        },
        changepage(url) {
            axios.get(url)
                .then(response => {
                    this.pagination(response.data);
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        },
        deletenote(index) {
            axios.delete('/note/' + index)
                .then(response => {
                    this.allnote();
                })
                .catch(error => {
                    this.errors = error.response.data.errors;
                });
        },
        cancel() {
            this.content = '';
        },
        pagination(data) {
            this.notes = data.data;
            this.total = data.total;
            this.next = data.next_page_url;
            this.prev = data.prev_page_url;
            this.first = data.first_page_url;
            this.last = data.last_page_url;
            this.lastpage = data.last_page;
            this.current = data.current_page;
        }
    },
    computed: {

    },
    mounted() {
        this.allnote();
    },
    watch: {

    },
}
</script>

<style>
.red {
    height: 100px;
    background: red;
    width: 200px;
}

.header {
    color: gray;
    font-size: 25px;
    font-family: fantasy;
}

.notfound {
    color: red;
    font-size: 20px;
    font-family: monospace;
    border-radius: 15px;
}

.border {
    border-radius: 50%;
}

.delete:active {
    background: red;
}

.noteborder {
    border-radius: 15px;
}
</style>
