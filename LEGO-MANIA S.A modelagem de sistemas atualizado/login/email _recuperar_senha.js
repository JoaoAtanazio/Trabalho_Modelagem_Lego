const express = require('express');
const nodemailer = require('nodemailer');
const bodyParser = require('body-parser');
const cors = require('cors');
const crypto = require('crypto');

const app = express();
app.use(cors());
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());

// Configurar Nodemailer com Gmail
const transporter = nodemailer.createTransport({
  service: 'gmail',
  auth: {
    user: 'seuemail@gmail.com', // substitua
    pass: 'sua-app-password'    // use App Password do Gmail
  }
});

// Rota para enviar o código
app.post('/enviar-codigo', (req, res) => {
  const email = req.body.email;
  const codigo = Math.floor(100000 + Math.random() * 900000); // código de 6 dígitos

  const mailOptions = {
    from: 'seuemail@gmail.com',
    to: email,
    subject: 'Seu código de verificação',
    text: `Seu código de verificação é: ${codigo}`
  };

  transporter.sendMail(mailOptions, (erro, info) => {
    if (erro) {
      console.error(erro);
      res.status(500).send('Erro ao enviar e-mail');
    } else {
      console.log('E-mail enviado: ' + info.response);
      res.send(`Código enviado para ${email}`);
    }
  });
});

app.listen(3000, () => {
  console.log('Servidor rodando na porta 3000');
});
