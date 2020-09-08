<template>
<div>
    <b-breadcrumb>
        <b-breadcrumb-item href="/"> Home</b-breadcrumb-item>
        <b-breadcrumb-item href="/projects">Projects</b-breadcrumb-item>
    </b-breadcrumb>
    <b-modal id="modal-prevent-closing" ref="modal" title="New Project" @cancel="cancel" @ok="save">
        <input type="text" class="form-control" placeholder="Name" v-model="name">
        <hr>
        <textarea class="form-control" placeholder="Content" v-model="content" rows="3"></textarea>
        <hr>
        <input type="url" class="form-control" placeholder="Url" v-model="url">
    </b-modal>
    <div class="header">
        <b-button v-b-modal.modal-prevent-closing class="btn btn-success btn-sm shadow-sm border border-0">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </b-button>
        <span>Projects : {{total}}</span>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-4 col-6 mb-2" v-for="(project, id) in projects" :key="project.id">
            <div class="card shadow-sm taskbordercomplete text-center">
                <div class="card-header bg-white"> {{project.name}}</div>
                <div class="card-body ">
                    {{project.content}}
                    <a class=" btn btn-outline-danger shadow-sm btn-sm delete-a border border-0" @click="deleteproject(project.id) || $event.target.classList.toggle('disabled')">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="card-header bg-white">
                    <a class="btn btn-link" :href="/project/+project.id"><i class="fa fa-link" aria-hidden="true"></i></a>
                    <a class="btn btn-link" :href="project.url"><i class="fas fa-hand-point-right"></i></a>
                </div>
            </div>
        </div>
        <h2 class="notfound col-12 text-center" v-if="projects.length==0">Not Found Projects</h2>
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
export default {
    data() {
        return {
            content: '',
            name: '',
            url: '',
            projects: [],
            total: 0,
            next: null,
            prev: null,
            first: null,
            last: null,
            current: null,
            lastpage: null,
        }
    },
    computed: {

    },
    mounted() {
        this.allproject();
    },
    methods: {
        allproject() {
            axios.get('/project?page=' + this.current)
                .then(response => {
                    this.pagination(response.data);
                })
                .catch(error => {
                    error.response.data.errors
                });
        },
        deleteproject(id) {
            axios.delete('/project/' + id)
                .then(response => {
                    this.allproject();
                })
                .catch(error => {
                    error.response.data.errors
                });
        },
        save() {
            axios.post('/project', {
                    content: this.content,
                    url: this.url,
                    name: this.name,
                })
                .then(response => {
                    this.content = '';
                    this.name = '';
                    this.url = '';
                    this.allproject();
                })
                .catch(error => {
                    error.response.data.errors
                });
        },
        cancel() {
            this.content = '';
            this.url = '';
            this.name = '';
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
        pagination(data) {
            this.projects = data.data;
            this.total = data.total;
            this.next = data.next_page_url;
            this.prev = data.prev_page_url;
            this.first = data.first_page_url;
            this.last = data.last_page_url;
            this.lastpage = data.last_page;
            this.current = data.current_page;
        }
    },
}
</script>

<style>
.card-header:first-child {
    border-top-right-radius: 15px;
    border-top-left-radius: 10px;
}

.card-header:last-child {
    border-bottom-right-radius: 15px;
    border-bottom-left-radius: 10px;
}

.delete-a {
    position: absolute;
    bottom: 3px;
    right: 4px;
    z-index: 4px;
}
</style>
