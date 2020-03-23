<<template>
    <div>
        <div class="entries flex flex-wrap items-stretch">
            <diary v-for="diary in items" :key="diary.id" :data="diary"></diary>
        </div>
        <paginator :dataSet="dataSet" @changed="fetch"></paginator>
    </div>
</template>
<script>
import diary from "./Diary";
export default {
  components: { diary },
  data() {
    return {
      items: "",
      dataSet: false
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
    }
  }
};
</script>