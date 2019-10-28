<template>
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Data Submission Form</h4>
          <form>
            <div class="form-group">
              <label class="control-label" for="name">Name</label>
              <input class="form-control" name="name" placeholder="Name" />
            </div>

            <div class="form-group">
              <label class="control-label" for="name">Email</label>
              <input class="form-control" name="email" type="email" placeholder="Name" />
            </div>

            <div class="form-group">
              <label class="control-label" for="name">Phone Number</label>
              <input class="form-control" name="phone_number" placeholder="Phone Number" />
            </div>

            <div class="form-group">
              <label class="control-label" for="name">Address</label>
              <input class="form-control" name="address" placeholder="Address" />
            </div>

            <div class="form-group">
              <label class="control-label" for="name">Zipcode</label>
              <input class="form-control" name="zipcode" type="number" placeholder="Zip Code" />
            </div>

            <div class="form-group">
              <label class="control-label">Photos</label>

              <div class="photos d-flex flex-row flex-wrap m-3">
                  
                <img v-for="image in images" :key="image.id" class="img-responsive mx-1" :src="'/storage/' +image.location" />
                

                <label class="control-label" for="image">
                  <a class="btn btn-outline-info pointer">Add photos</a>
                  <input
                    class="form-control"
                    id="image"
                    name="image"
                    type="file"
                    ref="image"
                    style="display:none"
                    @change="submitImages"
                  />
                </label>
              </div>
              <p :class='imageErrors.status'>{{imageErrors.message}}</p>
            </div>

            <div class="form-group">
              <label class="control-label">License Files</label>
              <div class="documents d-flex flex-column flex-wrap m-3">
                <ul class="list-group">
                  <li class="list-group-item my-1">File 1</li>
                  <li class="list-group-item my-1">File 2</li>
                  <label for="document" class="control-label my-1">
                    <a class="btn btn-outline-info pointer">Add Files</a>
                    <input
                      id="document"
                      class="form-control"
                      name="document"
                      type="file"
                      style="display:none"
                    />
                  </label>
                </ul>
              </div>
            </div>

            <input class="btn btn-info" type="submit" value="Submit" />
            <span v-if="loaded==false">working...</span>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    mounted(){
        this.loadImages();
    },
    data(){
        return {
            fields:{},
            errors:{},
            files:[],
            images:[],
            fileErrors:{},
            imageErrors:{status:'',message:''},
            success:false,
            loaded:true
        }
    },
    methods:{
        submit(){

        },
        submitFiles(){

        },
        submitImages(){
            let image = this.$refs.image.files[0];
            if(this.loaded && image){
                let formData = new FormData();
                formData.append('image',image);
                this.loaded=false;
                this.imageErrors.status = '';
                this.imageErrors.message='';
                axios.post('/upload-images',formData).then(response=>{
                    console.log(response);
                }).catch(e=>{
                    this.imageErrors.status = 'text-danger';
                    this.imageErrors.message = 'Failed to upload image. Response code: '+e.response.status;
                    
                })
            }
        },
        loadImages(){
            axios.get('get-images').then(response=>{
                this.images=response.data;
            })
        }
    }
}
</script>


<style scoped>
.pointer{
    cursor: pointer;
}
.photos img{
    max-width:200px;
}
</style>