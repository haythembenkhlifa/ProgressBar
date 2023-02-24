import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-progress-bar', IndexField)
  app.component('detail-progress-bar', DetailField)
  app.component('form-progress-bar', FormField)
})
