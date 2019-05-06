<template>
    <div class="chatroom">
        <ul>
            <a v-for="room in list_room" :key="room.id" :href="'/chat/'+room.id" :title="room.description" ><li class="room">{{ room.name }}</li></a>
        </ul> 
    </div>
</template>
<script>
export default {
    props : [],
    data(){
        return {
            list_room : []
        }
    },
    created(){
        this.getAllRoom()
                Echo.channel('rooms')
            .listen('RoomEvent', (data) => {
                this.list_room.push(data.room)
                })  
    },updated(){

    },
    methods : {
        getAllRoom(){
            axios.get('/allroom').then(res=>{
                this.list_room = res.data.data;
            }).catch(error=>{
                console.log(error);
            });
        },
    }
}
</script>
<style lang="scss">
    .chatroom {
        border: 1px dashed #ccc;
        height: 526px;
        overflow-y: scroll;
        ul{
            margin: 0;
            padding: 10px;
            a{
                text-decoration: none;
                li{
                padding: 10px 40px;
                list-style: none;
                
                }
                li:hover{
                    cursor: pointer;
                    border-radius: 5px;
                    background: #ecf1f7;
                    -webkit-box-shadow: 3px 4px 9px 4px #8fb4d8;
                    box-shadow: 3px 4px 9px 4px #8fb4d8
                }
            }
        }
    }
</style>
