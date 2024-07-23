<template>
  <div>
    <nav>
      <ul class="pagination">
        <li v-if="paginator.current_page > 1" class="page-item">
          <a class="page-link" href="#" @click.prevent="changePage(paginator.current_page - 1)">&laquo;</a>
        </li>

        <li v-for="page in pages" :key="page" :class="['page-item', { active: page === paginator.current_page }]">
          <a class="page-link" href="#" @click.prevent="changePage(page)">
            <span v-if="page === '...'">...</span>
            <span v-else>{{ page }}</span>
          </a>
        </li>

        <li v-if="paginator.current_page < paginator.last_page" class="page-item">
          <a class="page-link" href="#" @click.prevent="changePage(paginator.current_page + 1)">&raquo;</a>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  props: {
    paginator: {
      type: Object,
      required: true
    }
  },
  computed: {
    pages() {
      let pages = [];
      const currentPage = this.paginator.current_page;
      const lastPage = this.paginator.last_page;

      if (lastPage <= 7) {
        for (let i = 1; i <= lastPage; i++) {
          pages.push(i);
        }
      } else {
        pages.push(1);
        pages.push(2);

        let startPage = Math.max(currentPage - 2, 3);
        let endPage = Math.min(currentPage + 2, lastPage - 2);


        if (startPage > 3) {
          pages.push('...');
        }

        for (let i = startPage; i <= endPage; i++) {
          pages.push(i);
        }

        if (endPage < lastPage - 2) {
          pages.push('...');
        }

        pages.push(lastPage - 1);
        pages.push(lastPage);
      }

      return pages;
    }
  },
  methods: {
    changePage(page) {
      if (page === '...') return;
      this.$emit('page-change', page);
    }
  }
};
</script>

<style scoped>
.page-item.disabled .page-link {
  pointer-events: none;
}
</style>
