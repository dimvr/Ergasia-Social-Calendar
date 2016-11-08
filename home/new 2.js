$("#scheduler").kendoScheduler({
  // The current date of the scheduler
  date: new Date(),
  views: [
    "day",
    { type: "week", selected: true },
    "month"
  ]
});