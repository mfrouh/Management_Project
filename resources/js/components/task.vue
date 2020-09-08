<template>
<div>
    <b-modal id="modal-prevent-closing" ref="modal" title="New task" @cancel="cancel" @ok="save">
        <textarea class="form-control" placeholder="Content" v-model="content" rows="3"></textarea>
        <hr>
        <div class="form-group">
            <label for="">Complete :</label>
            <input type="checkbox" v-model="complete">
        </div>
    </b-modal>
    <div class="header">
        <b-button v-b-modal.modal-prevent-closing class="btn btn-success btn-sm shadow-sm border border-0">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </b-button>
        <span>
            Tasks : {{total}}
        </span>
    </div>
    <hr>
    <div class="card shadow-sm m-2" :class="checkborder(task.complete)" v-for="(task, id) in tasks" :key="task.id">
        <div class=" card-body">
            <input type="checkbox" :checked="check(task.complete)" @click="completetask(task.id)">
            <label :class="iscomplete(task.complete)">{{task.content}}</label>
            <a class=" btn btn-outline-danger shadow-sm btn-sm float-right border border-0" @click="deletetask(task.id) || $event.target.classList.toggle('disabled')">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    <div class="card shadow-sm m-2 notfound" v-if="tasks.length==0">
        <div class="card-body text-center  ">
            Not Found Tasks
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
            tasks: [],
            errors: [],
            complete: false,
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
        check(complete) {
            return complete === 'false' ? '' : 'checked';
        },
        checkborder(complete) {
            return complete === 'false' ? 'taskbordernotcomplete' : 'taskbordercomplete';
        },
        completetask(id) {
            axios.get('/task/complete/' + id)
                .then(response => {
                    this.alltask();
                })
                .catch(error => {
                    error.response.data.errors
                });
        },
        alltask() {
            axios.get('/task/' + this.project.id + '?page=' + this.current)
                .then(response => {
                    this.pagination(response.data);
                    this.$emit('comment');
                })
                .catch(error => {
                    error.response.data.errors
                });
        },
        deletetask(index) {
            axios.delete('/task/' + index)
                .then(response => {
                    this.alltask();
                })
                .catch(error => {
                    error.response.data.errors
                });
        },
        iscomplete(complete) {
            return [
                complete == 'false' ? 'notcomplete' : 'complete'
            ];
        },
        pagination(data) {
            this.tasks = data.data;
            this.total = data.total;
            this.next = data.next_page_url;
            this.prev = data.prev_page_url;
            this.first = data.first_page_url;
            this.last = data.last_page_url;
            this.lastpage = data.last_page;
            this.current = data.current_page;
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
        save() {
            axios.post('/task', {
                    content: this.content,
                    complete: this.complete ? 'true' : 'false',
                    project_id: this.project.id
                })
                .then(response => {
                    this.content = '';
                    this.complete = false;
                    this.alltask();
                })
                .catch(error => {
                    error.response.data.errors
                });
        },
        cancel() {
            this.content = '';
            this.complete = false;
        }
    },
    computed: {

    },
    mounted() {
        this.alltask();
    },
    watch: {

    },
}
</script>

<style>
.complete {
    font-size: 18px;
    color: green;
}

.taskbordercomplete {
    border-radius: 15px;
    border-left-color: green;
    border-left-width: thick;
}

.taskbordernotcomplete {
    border-radius: 15px;
    border-left-color: black;
    border-left-width: thick;
}

.notcomplete {
    font-size: 18px;
}
</style>
