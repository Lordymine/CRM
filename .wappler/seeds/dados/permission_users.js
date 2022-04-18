exports.seed = function(knex) {
  // Deletes ALL existing entries
  return knex('permissions').del()
    .then(function () {
      // Inserts seed entries
      return knex('permissions').insert([
  {
    "name": "Admin",
    "level": "10"
  },
  {
    "name": "Cliente",
    "level": "2"
  }
]);
    });
};