<template>
  <div>
    <div v-if="loaded==false" class="loader">
      <i class="fa-3x fa fa-spinner fa-spin"></i>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Data Submission Form</h4>
            <form @submit.prevent="submit">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label" for="name">Name</label>
                    <input
                      class="form-control w-75"
                      v-model ="$v.fields.name.$model"
                      name="name"
                      placeholder="Name"
                    />
                    <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                    <p class="text-danger" v-if="$v.fields.$anyError && !$v.fields.name.required">This field is required</p>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="name">Email</label>
                    <input
                      class="form-control w-75"
                      v-model ="$v.fields.email.$model"
                      name="email"
                      type="email"
                      placeholder="Name"
                    />
                    <div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>
                    <p class="text-danger" v-if="$v.fields.$anyError && !$v.fields.email.required">This field is required</p>
                                      <p class="text-danger" v-if="$v.fields.$anyError && !$v.fields.email.email">Should be valid email address</p>

                  </div>

                  <div class="form-group">
                    <label class="control-label" for="name">Phone Number</label>
                    <input
                      class="form-control w-75"
                      @change="checkPhone"
                      v-mask="'(999) 999-9999'"
                      v-model ="$v.fields.phone_number.$model"
                      name="phone_number"
                      placeholder="Phone Number"
                    />
                    <div
                      v-if="errors && errors.phone_number"
                      class="text-danger"
                    >{{ errors.phone_number[0] }}</div>
                    <p
                      class="text-danger"
                      v-if="$v.fields.$anyError && !$v.fields.phone_number.required"
                    >this field is required</p>
                  </div>
                  <div class="text-danger">{{ maskError }}</div>

                  <div class="form-group">
                    <label class="control-label" for="name">Address</label>
                    <input
                      class="form-control w-75"
                      v-model ="$v.fields.address.$model"
                      name="address"
                      placeholder="Address"
                    />
                    <div v-if="errors && errors.address" class="text-danger">{{ errors.address[0] }}</div>
                    <p class="text-danger" v-if="$v.fields.$anyError && !$v.fields.address.required">This field is required</p>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="name">Zipcode</label>
                    <input
                      v-mask="'99999'"
                      class="form-control w-75"
                      name="zipcode"
                      v-model ="$v.fields.zipcode.$model"
                      type="number"
                      placeholder="Zip Code"
                    />
                    <div v-if="errors && errors.zipcode" class="text-danger">{{ errors.zipcode[0] }}</div>
                    <p class="text-danger" v-if="$v.fields.$anyError && !$v.fields.zipcode.required">This field is required</p>
                    <p class="text-danger" v-if="$v.fields.$anyError && !$v.fields.zipcode.between">Should be of 5 digits</p>

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Photos</label>

                    <div class="photos d-flex flex-row flex-wrap m-3">
                      <div class="single-image" v-for="image in images" :key="image.id">
                        <img class="img-responsive mx-1" :src="'/storage/' +image.location" />
                        <span
                          title="Delete this image"
                          @click="deleteMedia"
                          :data-id="image.id"
                          class="badge badge-outline-secondary pointer"
                        >
                          <i class="fa fa-trash"></i>
                        </span>
                      </div>
                    </div>
                    <label class="control-label" for="image">
                      <a class="btn btn-outline-info pointer">
                        <i class="fa fa-upload mx-1"></i> Add photos
                      </a>
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
                    <p :class="imageErrors.status">{{imageErrors.message}}</p>
                    <div v-if="errors && errors.image" class="text-danger">{{ errors.image[0] }}</div>
                  </div>

                  <div class="form-group">
                    <label class="control-label">License Files</label>
                    <div class="documents d-flex flex-column flex-wrap m-3">
                      <ul class="list-group">
                        <li
                          v-for="file in files"
                          :key="file.id"
                          class="list-group-item list-group-item-light my-1"
                        >
                          <a href="#">{{file.name}}</a>
                          <span
                            title="Delete this File"
                            @click="deleteMedia"
                            :data-id="file.id"
                            class="badge badge-outline-secondary pointer text-dark"
                          >
                            <i class="fa-2x fa fa-trash"></i>
                          </span>
                        </li>

                        <label for="document" class="control-label my-1">
                          <a class="btn btn-outline-info pointer">
                            <i class="fa fa-upload mx-1"></i> Add Files
                          </a>
                          <input
                            id="document"
                            class="form-control"
                            name="document"
                            type="file"
                            style="display:none"
                            ref="file"
                            @change="submitFiles"
                          />
                        </label>
                        <p :class="fileErrors.status">{{fileErrors.message}}</p>
                      </ul>
                    </div>
                    <div v-if="errors && errors.file" class="text-danger">{{ errors.file[0] }}</div>
                  </div>

                  <input class="btn btn-info" type="submit" value="Submit" />
                  <p class="text-danger">{{this.errorMessage}}</p>
                  <p v-if="success==true" class="text-success">Successfully submitted the user data.</p>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { required,email,between } from "vuelidate/lib/validators";
export default {
  mounted() {
    this.loadImages();
    this.loadFiles();
  },
  data() {
    return {
      fields: {
        name: "",
        email: "",
        phone_number: "",
        address: "",
        zipcode: ""
      },
      errors: {},
      files: [],
      images: [],
      fileErrors: {},
      imageErrors: { status: "", message: "" },
      success: false,
      loaded: true,
      errorMessage: "",
      maskError: ""
    };
  },
  validations: {
    fields: {
      name: {
        required
      },
      email: {
        required,email
      },
      phone_number: {
        required
      },
      zipcode: {
        required,
        between:between(9999,100000)
      },
      address: {
        required
      }
    }
  },
  methods: {
    submit() {
      this.errors = "";
      this.errorMessage = "";
      
      if(!this.$v.fields.$anyDirty || this.$v.fields.$anyError){
        return;
      }
      axios
        .post("/submit-details", this.fields)
        .then(resp => {
          this.loaded = false;
          this.success = true;
          this.fields = {};
          this.errors = {};
          this.loadImages();
          this.loadFiles();
        })
        .catch(e => {
          if (e.response.status == 422) this.errors = e.response.data.errors;
          else
            this.errorMessage =
              "Error submitting form. Error code: " + e.response.status;
        })
        .finally(e => {
          this.loaded = true;
        });
    },
    submitFiles() {
      let file = this.$refs.file.files[0];
      if (this.loaded && file) {
        let formData = new FormData();
        formData.append("file", file);
        this.loaded = false;
        this.fileErrors.status = "";
        this.fileErrors.message = "";
        axios
          .post("/upload-files", formData)
          .then(response => {
            this.loadFiles();
          })
          .catch(e => {
            this.fileErrors.status = "text-danger";
            this.fileErrors.message =
              "Failed to upload file. Response code: " + e.response.status;
            if (e.response.status == 422)
              this.fileErrors.message = e.response.data.errors.file;
          })
          .finally(() => {
            this.loaded = true;
          });
      }
    },
    submitImages() {
      let image = this.$refs.image.files[0];
      if (this.loaded && image) {
        let formData = new FormData();
        formData.append("image", image);
        this.loaded = false;
        this.imageErrors.status = "";
        this.imageErrors.message = "";
        axios
          .post("/upload-images", formData)
          .then(response => {
            this.loadImages();
          })
          .catch(e => {
            this.imageErrors.status = "text-danger";
            this.imageErrors.message =
              "Failed to upload image. Response code: " + e.response.status;
            if (e.response.status == 422)
              this.imageErrors.message = e.response.data.errors.image;
          })
          .finally(() => {
            this.loaded = true;
          });
      }
    },
    loadImages() {
      this.images = [];
      axios.get("get-images").then(response => {
        this.images = response.data;
      });
    },
    loadFiles() {
      this.files = [];
      axios.get("get-files").then(response => {
        this.files = response.data;
      });
    },
    deleteMedia(e) {
      this.loaded = false;
      axios
        .get("/delete/" + e.currentTarget.dataset.id)
        .then(response => {
          this.loadImages();
          this.loadFiles();
          //display notification
        })
        .catch(e => {
          //display error notification
        })
        .finally(e => {
          this.loaded = true;
        });
    },
    checkPhone(e) {
      if (!e.currentTarget.inputmask.isComplete()) {
        this.maskError = "Please fill up the number correctly";
      } else this.maskError = "";
    }
  }
};
</script>


<style scoped>
.pointer {
  cursor: pointer;
}
.photos img {
  max-width: 130px;
}
.single-image {
  padding: 5px;
  display: flex;
  flex-direction: column;
}
.single-image span {
  align-self: start;
  font-size: large;
}

.loader {
  position: fixed;
  top: 0%;
  left: 0%;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  z-index: 9999;
  align-items: center;
  background: #ff07070f;
}
</style>