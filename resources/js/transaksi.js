import Vue from 'vue'
import axios from 'axios'
​
//import sweetalert library
import VueSweetalert2 from 'vue-sweetalert2';
​
Vue.filter('currency', function (money) {
    return accounting.formatMoney(money, "Rp ", 2, ".", ",")
})
​
//use sweetalert
Vue.use(VueSweetalert2);
​
new Vue({
    el: '#dw',
    data: {
        book: {
            id: '',
            price: '',
            title: '',
            cover: ''
        },
        //menambahkan cart
        cart: {
            book_id: '',
            quantity: 1
        },
        users: {
            email: ''
        },
        formUsers: false,
        resultStatus: false,
        submitForm: false,
        errorMessage: '',
        message: ' ' ,
        //untuk menampung list cart
        shoppingCart: [],
        submitCart: false
    },
    watch: {
        //apabila nilai dari product > id berubah maka
        'book.id': function() {
            //mengecek jika nilai dari product > id ada
            if (this.book.id) {
                //maka akan menjalankan methods getProduct
                this.getBook()
            }
        }
    },
    //menampilkan user
    'users.email': function() {
        this.formUsers = false
        if (this.users.name != '') {
            this.users = {
                name: '',
                phone: '',
                address: '' 
            }
        }
    },
    //menggunakan library select2 ketika file ini di-load
    mounted() {
        $('#book_id').select2({
            width: '100%'
        }).on('change', () => {
            //apabila terjadi perubahan nilai yg dipilih maka nilai tersebut 
            //akan disimpan di dalam var product > id
            this.book.id = $('#book').val();
        });
                //memanggil method getCart() untuk me-load cookie cart
        this.getCart()
    },
    methods: {

        searchUsers() {
            axios.post('/api/customer/search', {
                email: this.users.email
            })
            .then((response) => {
                if (response.data.status == 'success') {
                    this.users = response.data.data
                    this.resultStatus = true
                } 
                this.formUsers = true
            })
            .catch((error) => {
        ​
            })
        },
        // method sendOrder() kita biarkan kosong terlebih dahulu, section selanjutnya akan di modifikasi
        sendOrder() {
        ​
        } ,
        getBook() {
            //fetch ke server menggunakan axios dengan mengirimkan parameter id
            //dengan url /api/product/{id}
            axios.get(`/api/book/${this.book.id}`)
            .then((response) => {
                //assign data yang diterima dari server ke var product
                this.book = response.data
            })
        },
        
        //method untuk menambahkan product yang dipilih ke dalam cart
        addToCart() {
            this.submitCart = true;
            
            //send data ke server
            axios.post('/api/cart', this.cart)
            .then((response) => {
                setTimeout(() => {
                    //apabila berhasil, data disimpan ke dalam var shoppingCart
                    this.shoppingCart = response.data
                    
                    //mengosongkan var
                    this.cart.book_id = ''
                    this.cart.quantity = 1
                    this.book = {
                        id: '',
                        price: '',
                        title: '',
                        cover: ''
                    }
                    $('#book_id').val('')
                    this.submitCart = false
                }, 2000)
            })
            .catch((error) => {
​
            })
        },
        
        //mengambil list cart yang telah disimpan
        getCart() {
            //fetch data ke server
            axios.get('/api/cart')
            .then((response) => {
                //data yang diterima disimpan ke dalam var shoppingCart
                this.shoppingCart = response.data
            })
        },
        
        //menghapus cart
        removeCart(id) {
            //menampilkan konfirmasi dengan sweetalert
            this.$swal({
                title: 'Kamu Yakin?',
                text: 'Kamu Tidak Dapat Mengembalikan Tindakan Ini!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Iya, Lanjutkan!',
                cancelButtonText: 'Tidak, Batalkan!',
                showCloseButton: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve) => {
                        setTimeout(() => {
                            resolve()
                        }, 2000)
                    })
                },
                allowOutsideClick: () => !this.$swal.isLoading()
            }).then ((result) => {
                //apabila disetujui
                if (result.value) {
                    //kirim data ke server
                    axios.delete(`/api/cart/${id}`)
                    .then ((response) => {
                        //load cart yang baru
                        this.getCart();
                    })
                    .catch ((error) => {
                        console.log(error);
                    })
                }
            })
        }
    }
})