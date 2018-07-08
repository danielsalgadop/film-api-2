curl 127.0.0.1:8000/film/1/
curl 127.0.0.1:8000/actor/1/


curl 127.0.0.1:8000/api/actor/create/ -X POST -d '{"name":"nombre_actor"}' | jq
curl 127.0.0.1:8000/api/film/create/ -X POST -d '{"name":"pelicula", "description":"descipcion", "actor_id":"1"}' | jq

