<template>
    <div class="com-room">
        <div class="alert" :class="{'alert-success': status===true , 'alert-danger' : status===false }" >{{ message }}</div>
        <div class="create-room">
            <button class="btn btn-primary" @click="open_modal_create()"><i class="glyphicon glyphicon-plus"></i>Thêm Phòng</button>
        </div>
        <div class="list-my-room">
            <ul>
                <li v-for="room in list_my_room" :key="room.id" :data-name="room.name" :data-description="room.description">
                    <span>{{ room.name }}</span>
                    <div class="action">
                        <button class="btn btn-info btn-edit" @click="open_modal_edit"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-danger btn-delete" @click="open_modal_delete"><i class="fa fa-trash-alt"></i></button>
                    </div>
                </li>
            </ul>
        </div>
        <div class="modal-room"  id="modal-room">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Thêm mới phòng chat</h3>
                    <span class="close" @click="close_modal()">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Name : </label>
                        <input type="text" id="name" class="form-control" placeholder="Enter your room" v-model="name">
                    </div>
                    <div class="form-group">
                        <label for="">Description : </label>
                        <textarea id="des" cols="5" rows="3" class="form-control" @keyup="count_word" v-model="description"></textarea>
                        <p class="count">{{ number_word }}/300</p>
                    </div>
                    <input type="button" class="btn btn-primary mr-20" id="btn-addnew" value="addnew" @click="create_room()" :hidden="is_edit">
                    <input type="button" class="btn btn-primary mr-20" id="btn-edit" value="edit" :hidden="!is_edit">
                    <input type="button" class="btn btn-danger" id="btn-cancel"  value="cancel" @click="close_modal()">
                </div>
            </div>
        </div>
        <div class="modal-room"  id="modal-room-delete">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Xóa phòng</h3>
                    <span class="close" @click="close_modal_delete()">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="notify-delete">
                        <p>Có thể có nhiều thông tin quan trọng trong phòng chát ! </p>
                        <p>Bạn có chắc muốn xóa phòng : {{name}} ?</p>
                    </div>
                    <input type="button" class="btn btn-primary mr-20" id="btn-delete" value="Delete" @click="create_room()">
                    <input type="button" class="btn btn-danger" id="btn-cancel"  value="cancel" @click="close_modal_delete()">
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:[],
    data(){
        return {
            number_word : 0 ,
            name : '',
            description : '',
            message : '',
            status : '',
            list_my_room : [],
            is_edit : false
        }
    },
    created(){
        this.getMyroom()
    },
    updated (){
        this.number_word = this.description.length
    },
    methods : {
        open_modal_create(){
            var modal = document.querySelector('#modal-room');
            if( modal ){
                modal.style.display = "block";
                this.clean_input()
            }    
        },
        close_modal(){
            var modal = document.querySelector('#modal-room');
            if( modal ){
                modal.style.display = "none";
                this.clean_input()
            }     
        },
        clean_input(){
            this.number_word = 0;
            this.description = ''
            this.name = ''
            this.is_edit = false
        },
        getMyroom(){
            axios.get('/myroom').then(res=>{
                this.list_my_room = res.data.data;
            }).catch(error=>{
                console.log(error);
            });
        },
        create_room(){
            let name =  this.name
            let description =  this.description
            axios.post('/create-room',{ 
                name : name, 
                description : description, 
            }).then(res=>{
                if( res.data.hasOwnProperty('status') ){
                    this.status = res.data.status;
                    if(  this.status ){
                        this.list_my_room.push(  res.data.entry ) 
                        console.log( this.list_my_room )
                    }
                }
                if( res.data.hasOwnProperty('errors') ){
                    let message = '';
                    res.data.errors.forEach(element => {
                        message = message + element  
                    });
                    this.message = message
                }else if( res.data.hasOwnProperty('message') ){
                    this.message = res.data.message;
                }
                this.close_modal()
                this.notify()
            }).catch(err=>{
                console.log(err);
            });
        },
        count_word(event){
            this.number_word = this.description.length
        },
        notify(){
            var this_2 = this
            setTimeout(function(){
                this_2.status = '' 
                this_2.message = ''
            } , 1700 );
        },
        open_modal_delete(){
            var modal = document.querySelector('#modal-room-delete');
            if( modal ){
                modal.style.display = "block";
                this.name = event.target.parentNode.parentNode.getAttribute('data-name');
            }  
        },
        close_modal_delete(){
            var modal = document.querySelector('#modal-room-delete');
            if( modal ){
                modal.style.display = "none";
                this.name = "";
            }     
        },
        open_modal_edit(event){
            var modal = document.querySelector('#modal-room');
            if( modal ){
                modal.style.display = "block"
                this.is_edit = true
                this.name = event.target.parentNode.parentNode.getAttribute('data-name');
                this.description = event.target.parentNode.parentNode.getAttribute('data-description');
            }  
        }
    },
}
</script>

<style lang="scss">
    .com-room{
        margin: 0;
        padding: 0;
        .create-room{
            border: 1px dashed #ccc;
            padding: 20px 0;
            margin-bottom: 5px;
            display: flex;
            justify-content: center;
        }
        .list-my-room{
            border: 1px dashed #ccc;
            padding: 20px 0;
            height: 400px;
            overflow-y: scroll;
            ul{
                width: 100%;
                margin: 0;
                padding: 0 10px;
                li{
                    padding: 10px 0;
                    list-style: none;
                    overflow: hidden;   
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    span{
                        width: calc(100% - 95px);
                    }
                    .action{
                        width: 95px;
                        .btn-edit{
                            position: relative;
                            outline: none;
                            i{
                                display: none;
                            }
                        }
                        .btn-edit::before{
                            content: "\f044";
                            font-family: "Font Awesome 5 Free";
                        }
                        .btn-delete{
                            position: relative;
                            outline: none;
                            i{
                                display: none;
                            }
                        }
                        .btn-delete::before{
                            content: "\f2ed";
                            font-family: "Font Awesome 5 Free";
                        }   
                    }
                }
            }
        }
        .modal-room{
            display: none;
            position: fixed;
            top:0;
            left: 0;
            z-index: 1;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            .modal-content{
                width: 40%;
                margin: 10% auto;
                #btn-cancel{
                    margin-left: 50px;
                }
                .modal-body{
                    .notify-delete{
                        p{
                            margin: 0;
                        }
                        background: rgb(253, 169, 169);
                        padding: 20px;
                        margin-bottom: 10px;
                    }
                }
            }
            .close {
                color: #aaaaaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: #000;
                text-decoration: none;
                cursor: pointer;
            }
            .count{
                float: right;
                margin: -21px 10px;
                color: #808182;
            }
        }
    }
   
</style>

