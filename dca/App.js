import React from 'react';
import { NavigationContainer, StackActions } from '@react-navigation/native';
import { createStackNavigator } from '@react-navigation/stack';
import { createDrawerNavigator } from '@react-navigation/drawer';
import { StyleSheet, Text, View } from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';

import Icon from 'react-native-vector-icons/Ionicons';

import Home from './src/screens/Home';
import Music from './src/screens/Music';
import Login from './src/screens/Login';
import Post from './src/screens/Post';

import { DrawerContent } from './src/components/DrawerContent';

const HomeStack = createStackNavigator();
const MusicStack = createStackNavigator();
const Drawer = createDrawerNavigator();

const HomeStackScreen = ({navigation}) => (
    <HomeStack.Navigator screenOptions = {{
        headerStyle: {backgroundColor: '#e7cfc8'},
        headerTintColor: '#000',
        headerTitleStyle: {fontWeight: 'bold'}
    }}>
    <HomeStack.Screen name = "Home" component = {Home}
        options = {{headerLeft: () => (<Icon.Button style = {{paddingEnd: 0}} name = "ios-menu" size = {25} color = "#000" backgroundColor="#e7cfc8" onPress = {() => {navigation.openDrawer()}}></Icon.Button>)}}/>
    <HomeStack.Screen name = "Post" component = {Post}/>
    </HomeStack.Navigator>
);

const MusicStackScreen = ({navigation}) => (
    <MusicStack.Navigator screenOptions = {{
        headerStyle: {backgroundColor: '#e7cfc8'},
        headerTintColor: '#000',
        headerTitleStyle: {fontWeight: 'bold'}
    }}>
    <MusicStack.Screen name = "Music" component = {Music}
    options = {{headerLeft: () => (<Icon.Button name = "ios-menu" size = {25} color = "#000" backgroundColor="#e7cfc8" onPress = {() => {navigation.openDrawer()}}></Icon.Button>)}}/>
    <HomeStack.Screen name = "Post" component = {Post}/>
    </MusicStack.Navigator>
);

const App = () => {
    return (
        <NavigationContainer>
            <Drawer.Navigator drawerContent = {props => <DrawerContent {...props} />}>
                <Drawer.Screen name="Login" component={Login} />
                <Drawer.Screen name="Home" component={HomeStackScreen} />
                <Drawer.Screen name="Music" component={MusicStackScreen} />
            </Drawer.Navigator>
        </NavigationContainer>
    );
}

export default App;
