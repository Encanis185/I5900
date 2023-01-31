import * as React from 'react';
import { View, Text } from 'react-native';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import ActionsScreen from './ActionsScreen';
import AddCenter from './AddCenter';
import ModifyCenter from './ModifyCenter';
import DeleteCite from './DeleteCite';
import Centers from './Centers';
import AddCenterInfo from './AddCenterInfo';
import CenterInfo from './CenterInfo';


const Stack = createNativeStackNavigator();

function StackNavigator() {
    return (
        <NavigationContainer>
            <Stack.Navigator initialRouteName="Home">
                <Stack.Screen 
                    name="ActionsScreen"
                    component={ActionsScreen}
                    options={{headerShown: false}}
                />

                <Stack.Screen 
                    name="AddCenter"
                    component={AddCenter}
                    options={{headerShown: false}}
                />

                <Stack.Screen 
                    name="ModifyCenter"
                    component={ModifyCenter}
                    options={{headerShown: false}}
                />

                <Stack.Screen 
                    name="DeleteCite"
                    component={DeleteCite}
                    options={{headerShown: false}}
                />

                <Stack.Screen 
                    name="Centers"
                    component={Centers}
                    options={{headerShown: false}}
                />

                <Stack.Screen
                    name="AddCenterInfo"
                    component={AddCenterInfo}
                    options={{headerShown: false}}
                />

                <Stack.Screen
                    name="CenterInfo"
                    component={CenterInfo}
                    options={{headerShown: false}}
                />
            </Stack.Navigator>
        </NavigationContainer>
    );
}

export default StackNavigator;