<template>
    <transition name="modal-fade">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">

                    <div class="modal-header">
                        <slot name="header">
                            <h2>Add a book</h2>
                        </slot>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                            <form>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" v-model="name" placeholder="Book Title">
                                </div>
                                <div class="form-group">
                                    <label>Author</label>
                                    <input type="text" class="form-control" v-model="author" placeholder="Author">
                                </div>
                                <div class="form-group">
                                    <label>Genre</label>
                                    <input type="text" class="form-control" v-model="genre" placeholder="Genre">
                                </div>
                                <button type="button" class="btn btn-primary" @click="addBook()">Submit</button>
                            </form>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    export default {
        name: 'modal',
        data() {
            return {
                name: '',
                author: '',
                genre: ''
            }
        },
        mounted() {
        },
        methods: {
            addBook() {
                axios.post(`/api/books`, {
                    name: this.name,
                    author: this.author,
                    genre: this.genre
                }).then(response => {
                    this.name = '';
                    this.author = '';
                    this.genre = '';
                    this.$emit('close');
                })
            },
            close() {
                this.$emit('close');
            },
        }
    }
</script>

<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: table;
        transition: opacity 0.3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 300px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
        transition: all 0.3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-default-button {
        float: right;
    }

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>
