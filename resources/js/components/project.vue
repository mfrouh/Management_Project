<template>
<div>
    <b-breadcrumb>
        <b-breadcrumb-item href="/"> Home</b-breadcrumb-item>
        <b-breadcrumb-item href="/projects">Projects</b-breadcrumb-item>
        <b-breadcrumb-item :href="/project/+project.id">{{project.name}}</b-breadcrumb-item>
    </b-breadcrumb>
    <div class="row">
        <div class="col-md-8">
            <b-tabs content-class="mt-3 " justified>
                <b-tab title="Notes" active @click="activetab='notes'">
                    <notes :project="project" @comment="allcomments" v-if="activetab=='notes'"></notes>
                </b-tab>
                <b-tab title="Tasks" @click="activetab='tasks'">
                    <tasks :project="project" @comment="allcomments" v-if=" activetab=='tasks'"></tasks>
                </b-tab>
            </b-tabs>
        </div>
        <div class=" col-md-4">
            <div class="card shadow-sm taskbordercomplete ">
                <div class="card-header bg-white text-center">Comments</div>
                <div class="card-body">
                    <div v-for="(comment, id) in comments" :key="comment.id">
                        <span class="float-left"> {{ comment.comment| more }} </span>
                        <span class="float-right date"> {{ comment.created_at | age }} </span>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import moment from 'moment';
export default {
    props: ['project'],
    data() {
        return {
            activetab: 'notes',
            comments: [],
        }
    },
    mounted() {
        this.allcomments();
    },
    methods: {
        allcomments() {
            axios.get('/comments/' + this.project.id)
                .then(response => {
                    this.comments = response.data;
                })
                .catch(error => {
                    error.response.data.errors
                });
        },
    },
    filters: {
        age(date) {
            return moment(date).fromNow();
        },
        more(data) {
            if (data.length > 36) {
                return data.substring(0, 36) + ' ...';
            } else {
                return data;
            }
        },
    }

}
</script>

<style>
.date {
    font-family: cursive;
    color: gray;
    font-size: small;
}
</style>
