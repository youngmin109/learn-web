import express from 'express'

const app = express()

app.get('/', (req, res) => {
  res.send('get 방식')
})

app.get('/dog', (req, res) => {
  res.send('<h1>강아지</h1>')
})

app.get('/cat', (req, res) => {
  res.send('고양이')
})

app.listen(3000)