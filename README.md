CRM
===

## Goal

The goal of this project is to create a system capable of meeting the needs of small businesses that need to manage your projects and teams, promote campaigns and provide performance reports for your costumers.

The system must be healthy, scalable and will be developed to be prepared to grow up in modules and enhancements cycles.

## Tools

To achieve that goal, the set of technologies will be employed:

### Client-side
- jQuery <http://www.jquery.com>
- Underscore <http://underscorejs.org/>
- Backbone <http://backbonejs.org/>
- Twitter Bootstrap <http://twitter.github.com/bootstrap/>

### Server-side
- PHP Slim Framework <http://www.slimframework.com/>
- Possibly, MongoDB due its  "REST" prepared architecture.

## Architecture 

Development will be split in two parts, Server and Client. The server will be a RESTful, serving only JSON data accordingly to HTTP request it receives. The client will be responsible of all User Interface and Interation.

The modeling has to be decided first, and this is the next step the project.
