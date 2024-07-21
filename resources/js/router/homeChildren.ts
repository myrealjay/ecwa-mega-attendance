import Dashboard from "../views/Dashboard.vue"

const childRoutes = [
    {
        path: "",
        name: "dashboard",
        component: Dashboard
      },
      {
        path: "settings",
        name: "settings",
        component: () => import("../views/Settings.vue"),
      }
];

export function homeChildren() {
    return childRoutes;
}