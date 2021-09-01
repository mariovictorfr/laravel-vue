<template>
  <div class="task">
    <b-card class="border-0 shadow-sm" title="Tarefas" sub-title="Gerenciamento de tarefas">
      <hr class="my-4" />
      <b-overlay :show="loading" rounded="sm">
        <b-card-text>
          <b-row>
            <b-col cols="12" sm="8" offset-sm="2" md="6" offset-md="3" class="mb-4">
              <div class="input-group mb-3">
                <b-input
                  v-model="task.name"
                  type="text"
                  id="task"
                  class="form-control"
                  placeholder="Digite uma nova tarefa..."
                  @keyup.enter="saveTask"
                />
              </div>
              <b-button variant="primary" @click.prevent="saveTask" class="mr-4">
                {{ method === 'post' ? 'Adicionar Tarefa' : 'Alterar Tarefa' }}
              </b-button>
              <b-button variant="outline-secondary" @click.prevent="reset">Cancelar</b-button>
            </b-col>
            <b-col cols="12" sm="12" md="6" offset-md="3">
              <b-list-group>
                <b-list-group-item
                  v-for="task in tasks"
                  :key="task.id"
                  class="task-item d-flex align-items-center"
                >
                  <div class="task-status">
                    <b-form-checkbox
                      v-model="task.status"
                      :value="1"
                      @change="taskStatusChange(task)"
                    />
                  </div>
                  <div
                    class="task-name mr-4 flex-grow-1"
                    :class="task.status ? 'task-completed text-muted' : ''"
                  >
                    {{ task.name }}
                  </div>
                  <div class="task-date mr-4 text-muted" v-if="task.status">
                    <em>
                      <small>
                        {{ task.completedAt }}
                      </small>
                    </em>
                  </div>
                  <div class="task-actions">
                    <b-button
                      size="sm"
                      class="mr-3"
                      variant="light"
                      @click.prevent="loadTask(task)"
                      :disabled="loading"
                    >
                      <b-icon icon="pencil-fill"></b-icon>
                    </b-button>
                    <b-button
                      size="sm"
                      class="mr-3"
                      variant="light"
                      @click.prevent="deleteTask(task.id)"
                      :disabled="loading"
                    >
                      <b-icon icon="trash-fill"></b-icon>
                    </b-button>
                  </div>
                </b-list-group-item>
              </b-list-group>
            </b-col>
          </b-row>
        </b-card-text>
      </b-overlay>
    </b-card>
  </div>
</template>

<script>
import axios from 'axios'
import showError from '@/config/showError'

export default {
  data() {
    return {
      task: {},
      tasks: [],
      loading: false,
      method: 'post',
    }
  },

  methods: {
    async getTasks() {
      this.loading = true

      await axios(`${process.env.VUE_APP_API_URL}/tasks`)
        .then((res) => {
          this.tasks = []

          res.data.forEach((task) => {
            this.tasks.push({
              id: task.id,
              name: task.name,
              status: task.status,
              completedAt: task.completed_at
                ? new Date(task.completed_at).toLocaleString('pt-BR')
                : '',
            })
          })

          this.loading = false
        })
        .catch(showError)
    },

    async saveTask() {
      if (this.task && this.task.name) {
        this.loading = true

        let url = `${process.env.VUE_APP_API_URL}/tasks`
        if (this.method === 'put') {
          url += `/${this.task.id}`
        }

        await axios[this.method](url, { ...this.task })
          .then(() => {
            this.$toasted.success('Tarefa salva com sucesso.')
            this.loading = false
            this.reset()
            this.getTasks()
          })
          .catch(showError)
      } else {
        this.$toasted.error('O campo nome da tarefa é obrigatório.')
      }
    },

    async deleteTask(id) {
      this.loading = true

      await axios
        .delete(`${process.env.VUE_APP_API_URL}/tasks/${id}`)
        .then((res) => {
          this.$toasted.success(res.data)
          this.loading = false
          this.getTasks()
        })
        .catch(showError)
    },

    async taskStatusChange(task) {
      this.loading = true

      await axios
        .put(`${process.env.VUE_APP_API_URL}/tasks/${task.id}`, { ...task })
        .then(() => {
          this.$toasted.success('Tarefa salva com sucesso.')
          this.loading = false
          this.getTasks()
        })
        .catch(showError)
    },

    loadTask(task) {
      this.method = 'put'
      this.task = { ...task }
    },

    reset() {
      this.method = 'post'
      this.task = {}
    },
  },

  created() {
    this.getTasks()
  },
}
</script>

<style>
.task-actions > .btn {
  padding: 0.2rem 0.5rem;
  opacity: 0.2 !important;
}
.task-actions > .btn > .b-icon {
  width: 0.8rem;
  height: 0.8rem;
}

.task-item:hover .task-actions > .btn {
  opacity: 1 !important;
}

.task-completed {
  text-decoration: line-through;
}
</style>
