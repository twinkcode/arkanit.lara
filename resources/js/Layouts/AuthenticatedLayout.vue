<script setup>
import {ref} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Link} from '@inertiajs/vue3';
import PayoutsTable from '@/Components/Payouts/PayoutsTable.vue';

const drawer = ref(false);
const extMenu = ref(0);
const showingNavigationDropdown = ref(false);
</script>

<template>

  <div>
    <v-app>
      <v-navigation-drawer v-model="drawer">
        <v-list nav>
          <v-list-item prepend-icon="mdi-folder" title="Payouts" value="Payouts">
            <a :href="route('Payouts')" :active="route().current('Payouts')">
              Payouts
            </a>
          </v-list-item>
        </v-list>

      </v-navigation-drawer>

      <v-app-bar
          extended
          :extension-height="extMenu"
      >
        <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

        <v-toolbar-title>Arkanit TZ by @twinkcode</v-toolbar-title>

        <div class="ml-3 relative"
             @click="extMenu = extMenu === 0 ? 80 : 0"
        >
          <Dropdown align="right" width="48" class=" mr-3">
            <template #trigger>
                <span class="inline-flex rounded-md">
                    <button
                        type="button"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                    >
                        {{ $page.props.auth.user.name }}

                        <svg
                            class="ml-2 -mr-0.5 h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </span>
            </template>

            <template #content>
                <DropdownLink :href="route('profile.edit')"> Profile</DropdownLink>
                <DropdownLink :href="route('logout')" method="post" as="button">
                  Log Out
                </DropdownLink>
            </template>
          </Dropdown>
        </div>
      </v-app-bar>

      <v-main class="mt-10">
        <payouts-table/>
      </v-main>
    </v-app>
  </div>

</template>
