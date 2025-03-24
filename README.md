# Shopfinder GraphQL Module for Magento 2

A Magento 2 module that provides GraphQL API endpoints for managing shop locations, with a dedicated admin interface for shop management.

## Features

- GraphQL API for shop management (create, read, update)
- Admin interface for shop management under `Content > Shopfinder`
- Input validation for shop data
- Proper error handling and logging
- Country code standardization

## Installation

 Add the module to your project:
```bash
composer require hawksama/magento2-shopfinder-graphql
```

# GraphQL Endpoints

Here are practical examples of all available GraphQL operations for the Shopfinder module:

## Query All Shops
```
query {
  shops {
    shop_id
    name
    identifier
    country
  }
}
```

## Query Shop by ID
```
query {
  shopByIdentifier(identifier: "shop_in_romania") {
    shop_id
    name
    identifier
    country
  }
}

```

## Query Update Shop
```
mutation {
  updateShop(input: {
    shop_id: 1
    name: "Updated Shop Name"
    country: "RO"
  }) {
    shop {
      shop_id
      name
      identifier
      country
    }
  }
}
```

## Query Delete Shop
### This is not allowed via GraphQL, only via the admin interface
You can test it by using:
```
{
  "query": "mutation { deleteShop(id: 2) { success message } }"
}
```

## Query Create Shop
#### This is not allowed via GraphQL, only via the admin interface
```
{
    "query": "mutation { createShop(input: { name: \"Shop in Bulgaria\", identifier: \"shop_in_bulgaria\", country: \"BG\" }) { shop { shop_id name identifier country } } }"
}
```
