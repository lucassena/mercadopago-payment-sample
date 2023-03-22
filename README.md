# Mercado Pago - Payment Sample

### Table of Contents
1. [About](#about)
2. [Prerequisites](#prerequisites)
3. [Installation](#installation)
4. [Configuration](#configuration)
5. [Running](#running)
6. [Notes](#notes)

## About

Este é um exemplo de implementação de processamento de pagamentos com cartão de crédito e boleto utilizando Mercado Pago.

## Prerequisites

Você precisará ter instalado:
* git
* php 
* composer
* npm

## Installation

Para instalar siga estas etapas:

```shell
git clone git@github.com:lucassena/mercadopago-payment-sample.git
```

```shell
cd mercadopago-payment-sample
```

```shell
composer install
````

```shell
npm install
````

## Configuration

Após a instalação, você precisa fazer algumas modificações no arquivo .env:

1. Altere a chave APP_URL para, adicionando a porta 8000:
```text
APP_URL=http://localhost:8000
```

2. Adicionado as variaveis relacionadas ao Mercado Pago:
```text
MERCADO_PAGO_PUBLIC_KEY=SUA_PUBLIC_KEY
MERCADO_PAGO_ACCESS_TOKEN=SEU_ACCESS_TOKEN
```

## Running

Agora você está pronto para rodar esta aplicação!

1. Em um terminal rode:
```shell
npm run dev
```

2. Em outro terminal:
```shell
php artisan serve
```

Agora você pode acessar http://localhost:8000 

## Notes

Qualquer dúvida estou a disposição!

