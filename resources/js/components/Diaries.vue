<template>
  <div v-if="addnew">
    <resizable-textarea>
      <textarea
        class="whitespace-pre-wrap notebook w-full px-3 text-sm leading-tight dark:bg-gray-800 dark:text-white border rounded shadow appearance-none focus:outline-none"
        name="entry"
        id="entry"
        cols="30"
        rows="10"
        placeholder="It was an awesome day."
        required
        autofocus
        v-model="entry"
      ></textarea>
    </resizable-textarea>
    <button
      class="mt-4 bg-blue-100 active:bg-blue-200 text-blue-800 px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
      :disabled="disabled"
      v-text="btnText"
      @click="save"
    ></button>
    <button
      class="mt-4 bg-gray-600 text-gray-100 px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
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
</template>
<script>
import diary from "./Diary.vue";
import share from "./Share.vue";
export default {
  components: { diary, share },
  data() {
    return {
      items: "",
      dataSet: false,
      addnew: false,
      entry: "",
      disabled: false,
    };
  },
  created() {
    this.saveFromStorage();
    this.fetch();
  },
  computed: {
    btnText() {
      return this.disabled ? "Saving..." : "Save";
    },
  },
  methods: {
    fetch(page) {
      flash("We are fetching your diary. Please wait...");
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
        this.disabled = true;
        axios
          .post("/diaries", { entry: this.entry })
          .then(this.saved)
          .catch(this.handleCatch)
          .finally(() => {
            this.disabled = false;
          });
      } else {
        flash("You can not save empty diary . please write.", "danger");
      }
    },
    saved() {
      flash("Diary saved successfully");
      this.resetForm();
      let query = location.search.match(/page=(\d+)/);
      let page = query ? query[1] : 1;
      if (page == 1) {
        this.fetch();
      }
    },
    handleCatch(error) {
      if (!error.response) {
        this.handleOffline();
      } else {
        flash(error.response.data.message, "danger");
      }
    },
    handleOffline() {
      let data = this.getStoredEntries();

      data.toSave.push({
        entry: this.entry,
        created_at: new Date().toISOString(),
      });

      this.setEntries(data);

      this.resetForm();

      flash("Diary will updated when connected to network");
    },
    resetForm() {
      this.addnew = false;
      this.entry = "";
    },
    saveFromStorage() {
      let entries = this.getStoredEntries();
      let token = document.querySelector('meta[name="csrf-token"]').content

      if (entries.toSave.length) {
        let items = entries.toSave;
        items.forEach((item, index) => {
            let data = {
                entry: item.entry,
                created_at: item.created_at,
                _token : token
            }
          axios
            .post("/diaries", data)
            .then(this.removeFromStorage(index))
            .catch(this.handleCatch);
        });

        this.saved();
      }
    },
    getStoredEntries() {
      let entries = localStorage.getItem("entries");

      if (entries) {
        return JSON.parse(entries);
      }

      entries = { toSave: [] };
      this.setEntries(entries);

      return this.getStoredEntries();
    },
    setEntries(item) {
      try {
        localStorage.setItem("entries", JSON.stringify(item));
      } catch (error) {
        console.log(error);
      }
    },
    removeFromStorage(index) {
      let entries = this.getStoredEntries();
      entries.toSave.splice(index, 1);
      return this.setEntries(entries);
    },
  },
};
</script>
