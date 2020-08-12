<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <modal
                    v-show="isModalVisible"
                    @close="closeModal"
                />

                <div class="search-wrapper panel-heading col-sm-8">
                    <button
                        type="button"
                        class="btn"
                        @click="showModal"
                    >
                        Add Book
                    </button>
                    <input class="form-control" type="text" v-model="searchQuery" placeholder="Search" />
                </div>

                <div class="col-md-8">
                    <ul class="list-group">
                        <li v-for="(book, index) in filteredBooks" class="list-group-item">
                            <div class="row">
                                <div class="col-3">
                                    <img v-bind:src="'/images/' + book.image" class="img-thumbnail" />
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-3"></div>
                                        <div class="col-8">
                                            <input type="text" v-model="book.name" :disabled="!book.isEditing"
                                                   :class="{view: !book.isEditing}" >
                                            <div v-if="book.isEditing" @click="saveBook(book)" class="save-button"><i class="fa fa-check"></i></div></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">Author</div>
                                        <div class="col-8">
                                            <input type="text" v-model="book.author" :disabled="!book.isEditing"
                                                   :class="{view: !book.isEditing}" >
                                            <div v-if="book.isEditing" @click="saveBook(book)" class="save-button"><i class="fa fa-check"></i></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">Genre</div>
                                        <div class="col-8">
                                            <input type="text" v-model="book.genre" :disabled="!book.isEditing"
                                                   :class="{view: !book.isEditing}" >
                                            <div v-if="book.isEditing" @click="saveBook(book)" class="save-button"><i class="fa fa-check"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="btn-group btn-group-xs" role="group">
                                        <button type="btn btn-default btn-sm" @click="book.isEditing = !book.isEditing" class="btn btn-default">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button type="btn btn-default btn-sm" @click="removeBook(book)" class="btn btn-default">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                books: [],
                searchQuery: null,
                isEditing: false,
                isModalVisible: false,
            }
        },
        mounted() {
            this.getBooks();
        },
        computed: {
            filteredBooks() {
                if (this.searchQuery) {
                    return this.books.filter((book)=>{
                        return this.searchQuery.toLowerCase().split(' ').every(v => book.name.toLowerCase().includes(v))
                    })
                } else {
                    return this.books;
                }
            }
        },
        methods: {
            getBooks() {
                axios.get(`/api/books`).then(response => {
                    this.books = response.data.data;
                })
            },
            saveBook(book) {
                axios.put(`/api/books/` + book.id, {
                    name: book.name,
                    author: book.author,
                    genre: book.genre
                }).then(response => {})
            },
            removeBook(book) {
                axios.delete(`/api/books/` + book.id, {
                    name: book.id
                }).then(response => {
                    this.getBooks();
                })
            },
            showModal() {
                this.isModalVisible = true;
            },
            closeModal() {
                this.isModalVisible = false;
                this.getBooks();
            }
        }
    }
</script>

<style>
    .btn {
        background-color: DodgerBlue;
        border: none;
        color: white;
        padding: 12px 16px;
        font-size: 16px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: RoyalBlue;
    }
    .view {
        border-color: transparent;
        background-color: initial;
        color: initial
    }
</style>
