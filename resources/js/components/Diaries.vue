<template>
  <div>
    <div v-if="addnew" v-cloak>
      <resizable-textarea>
        <textarea
          class="notebook w-full px-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none"
          name="entry"
          id="entry"
          cols="30"
          rows="10"
          placeholder="Its was an awesome day today."
          required
          autofocus
          v-model="entry"
        ></textarea>
      </resizable-textarea>
      <button
        class="mt-4 bg-blue-100 active:bg-blue-200 text-blue-800 font-normal px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
        @click="save"
      >Save</button>
      <button
        class="mt-4 bg-gray-600 text-gray-100 font-normal px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
        @click="addnew=false"
      >Cancel</button>
    </div>
    <div v-else>
      <div class="entries flex flex-wrap items-stretch">
        <diary v-for="diary in items" :key="diary.id" :data="diary"></diary>
      </div>
      <paginator :dataSet="dataSet" @changed="fetch" v-cloak></paginator>
      <div class="fixed right-0 bottom-0 mb-6 mr-6">
        <share class="md:hidden mb-2 p-4 rounded-full w-full bg-blue-200 shadow hover:shadow-lg"></share>
        <div
          class="p-4 md:pb-6 rounded-full text-bold text-4xl h-12 w-12 bg-blue-200 text-blue-800 shadow hover:shadow-lg flex justify-center items-center"
          title="Add new"
          @click="addnew=true"
        >+</div>
      </div>
    </div>
  </div>
</template>
<script>
import diary from "./Diary";
import share from "./Share";
export default {
  components: { diary, share },
  data() {
    return {
      items: "",
      dataSet: false,
      addnew: false,
      entry: "",
      saving: false
    };
  },
  created() {
    this.fetch();
  },
  methods: {
    fetch(page) {
      axios.get(this.url(page)).then(this.refresh);
    },
    url(page) {
      if (!page) {
        let query = location.search.match(/page=(\d+)/);
        page = query ? query[1] : 1;
      }
      return "/diaries?page=" + page;
    },
    refresh({ data }) {
      this.dataSet = data;
      this.items = data.data;
      window.scrollTo(0, 0);
    },
    save() {
      if (this.entry.trim().length) {
        if (!this.saving) {
          this.saving = true;
          axios
            .post("/diaries", { entry: this.entry })
            .then(this.saved)
            .catch(this.handleCatch);
        }
      } else {
        flash("You can not save empty diary . please write.", "warning");
      }
    },
    handleCatch(error) {
      if (!navigator.onLine) {
        this.handleOffline(error);
        return;
      }
      this.saving = false;
      flash(error.response.data.message, "danger");
    },
    handleOffline(error) {
      let data = this.getEntries();

      let entry = JSON.parse(error.config.data);

      data.toSave.push({
        entry: entry.entry,
        created_at: new Date().toISOString()
      });

      this.setEntries(data);

      this.resetForm();

      flash("Diary will updated when connected to network", "warning");
    },
    resetForm() {
      this.addnew = false;
      this.saving = false;
      this.entry = "";
    },
    saved() {
      flash("Diary saved successfully");
      this.resetForm();
      let query = location.search.match(/page=(\d+)/);
      let page = query ? query[1] : 1;
      if (page == 1) {
        this.fetch();
      }
      this.savefromstorage();
    },
    savefromstorage() {
      let entries = this.getEntries();

      if (entries.toSave.length) {
        let items = entries.toSave;
        items.forEach((item, index) => {
          axios
            .post("/diaries", item)
            .then(this.savedfromstorage(index))
            .catch(this.handleCatch);
        });
      }
    },
    getEntries() {
      if (localStorage.getItem("entries")) {
        return JSON.parse(localStorage.getItem("entries"));
      }
      let emptyEntries = { toSave: [] };
      localStorage.setItem("entries", JSON.stringify(emptyEntries));
      return this.getEntries();
    },
    setEntries(item) {
      try {
        localStorage.setItem("entries", JSON.stringify(item));
      } catch (error) {
        console.log(error);
      }
    },
    savedfromstorage(index) {
      let entries = this.getEntries();
      entries.toSave.splice(index, 1);
      this.setEntries(entries);
      this.saved();
    }
  }
};
</script>